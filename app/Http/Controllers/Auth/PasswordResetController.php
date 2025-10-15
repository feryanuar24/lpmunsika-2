<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RecaptchaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    /**
     * Show form to request password reset link.
     */
    public function create()
    {
        return view('pages.forgot-password.index');
    }

    /**
     * Send reset link to email.
     */
    public function store(Request $request)
    {
        $recaptchaResult = RecaptchaHelper::validateRecaptcha($request);

        if (!$recaptchaResult['success']) {
            return back()
                ->with('error', $recaptchaResult['message'])
                ->onlyInput('email');
        }

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users']
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Tautan untuk mereset kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk dan folder spam.');
        }

        return back()->with('error', 'Gagal mengirim tautan reset kata sandi. Periksa alamat email dan coba lagi.');
    }

    /**
     * Show form to reset password.
     */
    public function edit(string $token, Request $request)
    {
        try {
            $data = [
                'token' => $token,
                'email' => $request->query('email')
            ];

            return view('pages.forgot-password.edit', compact('data'));
        } catch (InvalidSignatureException $e) {
            Log::error('Invalid signature in password reset link: ' . $e->getMessage());

            return redirect()->route('password.request')->with('error', 'Link reset password tidak valid atau telah kedaluwarsa. Silakan minta link baru.');
        }
    }

    /**
     * Handle reset password request.
     */
    public function update(Request $request)
    {
        try {
            $recaptchaResult = RecaptchaHelper::validateRecaptcha($request);

            if (!$recaptchaResult['success']) {
                return back()
                    ->with('error', $recaptchaResult['message'])
                    ->onlyInput('email');
            }

            $request->validate([
                'token'    => ['required', 'string'],
                'email'    => ['required', 'string', 'email', 'max:255', 'exists:users'],
                'password' => ['required', 'min:8', 'confirmed'],
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    Auth::login($user);

                    $request->session()->regenerate();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->intended('/dashboard')->with('success', 'Kata sandi berhasil direset. Anda telah otomatis masuk.');
            }

            return back()->with('error', 'Gagal mereset kata sandi. Token tidak valid atau data tidak cocok.');
        } catch (InvalidSignatureException $e) {
            Log::error('Invalid signature in password reset link: ' . $e->getMessage());

            return redirect()->route('password.request')->with('error', 'Link reset password tidak valid atau telah kedaluwarsa. Silakan minta link baru.');
        }
    }
}
