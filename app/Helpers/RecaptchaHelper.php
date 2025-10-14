<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaHelper
{
    /**
     * Validate reCAPTCHA response from Google
     *
     * @param Request $request
     * @param float $minScore Minimum score required (default: 0.5)
     * @return array ['success' => bool, 'message' => string, 'score' => float|null]
     */
    public static function validateRecaptcha(Request $request): array
    {
        $validator = validator($request->all(), [
            'g-recaptcha-response' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Tanggapan reCAPTCHA diperlukan.',
                'score' => null
            ];
        }

        try {
            $response = Http::timeout(10)->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key', env('RECAPTCHA_SECRET_KEY')),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'Gagal memverifikasi reCAPTCHA. Silakan coba lagi.',
                    'score' => null
                ];
            }

            $success = $responseData['success'] ?? false;
            $score = $responseData['score'] ?? 0;

            if (!$success || $score < 0.5) {
                return [
                    'success' => false,
                    'message' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
                    'score' => $score
                ];
            }

            return [
                'success' => true,
                'message' => 'Verifikasi reCAPTCHA berhasil.',
                'score' => $score
            ];
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Verifikasi reCAPTCHA gagal karena kesalahan server. Silakan coba lagi nanti.',
                'score' => null
            ];
        }
    }
}
