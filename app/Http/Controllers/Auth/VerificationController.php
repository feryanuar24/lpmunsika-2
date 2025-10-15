<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RecaptchaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * Show the verification notice.
     */
    public function create()
    {
        return view('pages.verify-email.index');
    }

    /**
     * Send the verification email.
     */
    public function store(Request $request)
    {
        try {
            $recaptchaResult = RecaptchaHelper::validateRecaptcha($request);

            if (!$recaptchaResult['success']) {
                return back()
                    ->with('error', $recaptchaResult['message']);
            }

            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->route('dashboard');
            }

            $request->user()->sendEmailVerificationNotification();

            return back()->with('success', 'Link verifikasi telah dikirim ke email Anda.');
        } catch (InvalidSignatureException $e) {
            Log::error('Error sending verification email: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat mengirim email verifikasi. Silakan coba lagi.');
        }
    }

    /**
     * Handle the verification callback.
     */
    public function update(EmailVerificationRequest $request)
    {
        try {
            $request->fulfill();

            return redirect()->route('dashboard')->with('success', 'Verifikasi email berhasil!');
        } catch (InvalidSignatureException $e) {
            Log::error('Error during email verification: ' . $e->getMessage());

            return redirect()->route('verification.notice')->with('error', 'Link verifikasi tidak valid atau telah kedaluwarsa. Silakan minta link baru.');
        }
    }
}
