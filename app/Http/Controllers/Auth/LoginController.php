<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\RecaptchaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
        $recaptchaResult = RecaptchaHelper::validateRecaptcha($request);

        if (!$recaptchaResult['success']) {
            return back()
                ->with('error', $recaptchaResult['message'])
                ->onlyInput('email');
        }

        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();
        $maxAttempts = 5;
        $decaySeconds = 900;

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->with('error', "Terlalu banyak percobaan login. Silakan tunggu sekitar {$minutes} menit dan coba lagi.")->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember_me'))) {
            $request->session()->regenerate();

            RateLimiter::clear($throttleKey);

            $user = Auth::user();
            if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();

                return redirect()->route('verification.notice')->with('info', 'Silakan verifikasi email Anda terlebih dahulu. Kami telah mengirimkan link verifikasi ke email Anda.');
            }

            return redirect()->intended('/dashboard')->with('success', 'Login Berhasil!');
        }

        RateLimiter::hit($throttleKey, $decaySeconds);
        $remaining = $maxAttempts - RateLimiter::attempts($throttleKey);

        return back()
            ->with('error', "Login Gagal! Silakan periksa kembali email dan password Anda. Anda memiliki {$remaining} percobaan tersisa.")
            ->onlyInput('email');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout Berhasil!');
    }
}
