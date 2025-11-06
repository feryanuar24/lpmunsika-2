<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('pages.profile.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('pages.profile.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $messages = [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama maksimal :max karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email maksimal :max karakter.',
                'email.unique' => 'Email sudah digunakan.',
                'password.min' => 'Password minimal :min karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
            ];

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
                'password' => [
                    'nullable',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->with('error', implode('<br>', $validator->errors()->all()))
                    ->withInput();
            }

            $validated = $validator->validated();

            $user = User::findOrFail(Auth::id());

            DB::beginTransaction();

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Memperbarui Akun',
                'message' => 'Pengguna ' . ($user->name ?? 'System') . ' berhasil memperbaharui akun.',
            ]);

            DB::commit();

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Error updating profile: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            User::destroy($user->id);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Menghapus Akun',
                'message' => 'Pengguna ' . ($user->name ?? 'System') . ' berhasil menghapus akun.',
            ]);

            DB::commit();

            Auth::logout();

            return redirect()->route('landing')->with('success', 'Akun Anda telah dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Error deleting profile: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus akun Anda.');
        }
    }
}
