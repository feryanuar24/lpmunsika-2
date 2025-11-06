<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RecaptchaHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.register.index');
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
                    ->onlyInput('name', 'email');
            }

            $messages = [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
                'email.unique' => 'Email sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal :min karakter.',
                'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
                'avatar.required' => 'Avatar wajib diisi.',
                'avatar.string' => 'Avatar harus berupa teks.',
            ];

            $validator = Validator::make($request->all(), [
                'name'                  => ['required', 'string', 'max:255'],
                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'              => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
                'avatar'                => ['required', 'string'],
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->withInput()
                    ->with('error', implode('<br>', $validator->errors()->all()));
            }

            $validated = $validator->validated();

            DB::beginTransaction();

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'avatar'   => $validated['avatar'],
            ]);

            $user->addRole('visitor');

            Auth::login($user);

            $user->sendEmailVerificationNotification();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Pengguna Mendaftar',
                'message' => 'Pengguna ' . ($user->name ?? 'System') . ' telah berhasil mendaftar.',
            ]);

            DB::commit();

            return redirect()->route('verification.notice')->with('success', 'Akun dibuat. Silakan cek email Anda untuk link verifikasi.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during user registration: ' . $th->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar');
        }
    }
}
