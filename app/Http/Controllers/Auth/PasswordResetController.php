<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RecaptchaHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\DB;

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
                'email.exists' => 'Email tidak terdaftar.',
            ];

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255', 'exists:users']
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->with('error', implode('<br>', $validator->errors()->all()))
                    ->onlyInput('email');
            }

            $status = Password::sendResetLink(
                $validator->validated()
            );

            if ($status !== Password::RESET_LINK_SENT) {
                return back()->with('error', 'Gagal mengirim tautan reset kata sandi. Periksa alamat email dan coba lagi.');
            }

            return back()->with('success', 'Tautan untuk mereset kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk dan folder spam.');
        } catch (Throwable $th) {
            Log::error('Error during password reset link request: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat mengirim email reset kata sandi.')
                ->onlyInput('email');
        }
    }

    /**
     * Show form to reset password.
     */
    public function edit(string $token, Request $request)
    {
        $data = [
            'token' => $token,
            'email' => $request->query('email')
        ];

        return view('pages.forgot-password.edit', compact('data'));
    }

    /**
     * Handle reset password request.
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $recaptchaResult = RecaptchaHelper::validateRecaptcha($request);

            if (!$recaptchaResult['success']) {
                return back()
                    ->with('error', $recaptchaResult['message'])
                    ->onlyInput('email');
            }

            $messages = [
                'token.required' => 'Token reset wajib disertakan.',
                'token.string' => 'Token reset tidak valid.',
                'email.required' => 'Email wajib diisi.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
                'email.exists' => 'Email tidak terdaftar.',
                'password.required' => 'Password baru wajib diisi.',
                'password.min' => 'Password baru minimal :min karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ];

            $validator = Validator::make($request->all(), [
                'token'    => ['required', 'string'],
                'email'    => ['required', 'string', 'email', 'max:255', 'exists:users'],
                'password' => ['required', 'min:8', 'confirmed'],
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->with('error', implode('<br>', $validator->errors()->all()))
                    ->onlyInput('email');
            }

            $updatedUserId = null;
            $updatedUserName = null;
            $status = Password::reset(
                $validator->validated(),
                function ($user, $password) use ($request, &$updatedUserId, &$updatedUserName) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    Auth::login($user);
                    $request->session()->regenerate();
                    $updatedUserId = $user->id;
                    $updatedUserName = $user->name;
                }
            );

            if ($status !== Password::PASSWORD_RESET) {
                DB::rollBack();

                return back()->with('error', 'Gagal mereset kata sandi. Token tidak valid atau data tidak cocok.');
            }

            Notification::create([
                'user_id' => $updatedUserId,
                'title' => 'Pengguna Memperbaharui Kata Sandi',
                'message' => 'Pengguna ' . ($updatedUserName ?? 'System') . ' berhasil memperbaharui kata sandinya.',
            ]);

            DB::commit();

            return redirect()->intended('/dashboard')->with('success', 'Kata sandi berhasil direset. Anda telah otomatis masuk.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during password reset: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat memproses permintaan reset kata sandi.')
                ->onlyInput('email');
        }
    }
}
