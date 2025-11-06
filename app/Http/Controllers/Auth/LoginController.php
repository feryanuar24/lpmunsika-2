<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\RecaptchaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LoginController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.login.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $recaptchaResult = RecaptchaHelper::validateRecaptcha($request);

            if (!$recaptchaResult['success']) {
                return back()
                    ->with('error', $recaptchaResult['message'])
                    ->onlyInput('email');
            }

            $messages = [
                'email.required' => 'Email wajib diisi.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
                'email.exists' => 'Email belum terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.string' => 'Password harus berupa teks.',
            ];

            $validator = Validator::make($request->all(), [
                'email'    => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
                'password' => ['required', 'string'],
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->with('error', implode('<br>', $validator->errors()->all()))
                    ->onlyInput('email');
            }

            $credentials = $validator->validated();

            $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();
            $maxAttempts = 5;
            $decaySeconds = 900;

            if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                $minutes = ceil($seconds / 60);
                return back()
                    ->with('error', "Terlalu banyak percobaan login. Silakan tunggu sekitar {$minutes} menit dan coba lagi.")
                    ->onlyInput('email');
            }

            if (!Auth::attempt($credentials, $request->boolean('remember_me'))) {
                RateLimiter::hit($throttleKey, $decaySeconds);
                $remaining = $maxAttempts - RateLimiter::attempts($throttleKey);
                return back()
                    ->with('error', "Login Gagal! Silakan periksa kembali email dan password Anda. Anda memiliki {$remaining} percobaan tersisa.")
                    ->onlyInput('email');
            }

            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);
            $user = Auth::user();
            if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
                return redirect()->route('verification.notice')->with('success', 'Silakan verifikasi email Anda terlebih dahulu. Kami telah mengirimkan link verifikasi ke email Anda.');
            }
            return redirect()->intended('/dashboard')->with('success', 'Login Berhasil!');
        } catch (Throwable $th) {
            Log::error('Error during user login: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat proses login.')
                ->onlyInput('email');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('landing')->with('success', 'Logout Berhasil!');
        } catch (Throwable $th) {
            Log::error('Error during user logout: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat proses logout.');
        }
    }
}
