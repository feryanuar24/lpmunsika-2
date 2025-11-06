<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'users' => User::with('roles')->get(),
        ];

        return view('pages.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'roles' => Role::all(),
        ];

        return view('pages.users.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
                'roles.required' => 'Role wajib dipilih.',
                'roles.array' => 'Format role tidak valid.',
                'roles.*.exists' => 'Role tidak valid.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal :min karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
            ];

            $validator = Validator::make($request->all(), [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'roles'    => ['required', 'array'],
                'roles.*'  => ['exists:roles,name'],
                'password' => [
                    'required',
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

            DB::beginTransaction();

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'email_verified_at' => now(),
                'password' => bcrypt($validated['password']),
            ]);

            $user->addRoles($validated['roles']);

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Pengguna Ditambahkan',
                'message' => 'Pengguna ' . ($user->name ?? 'System') . ' berhasil ditambahkan.',
            ]);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during user creation: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat menambahkan user')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $data = [
            'user' => $user
        ];

        return view('pages.users.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = [
            'user' => $user,
            'roles' => Role::all(),
        ];

        return view('pages.users.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
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
                'roles.required' => 'Role wajib dipilih.',
                'roles.array' => 'Format role tidak valid.',
                'roles.*.exists' => 'Role tidak valid.',
                'password.min' => 'Password minimal :min karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
            ];

            $validator = Validator::make($request->all(), [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'roles'    => ['required', 'array'],
                'roles.*'  => ['exists:roles,name'],
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

            DB::beginTransaction();

            $user->name  = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->syncRoles($validated['roles']);

            $user->save();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Pengguna Diperbaharui',
                'message' => 'Pengguna ' . ($user->name ?? 'System') . ' berhasil diperbaharui.',
            ]);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during user update: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui user')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            $user->delete();

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Dihapus',
                'message' => 'Pengguna ' . ($user->name ?? 'System') . ' berhasil dihapus.',
            ]);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during user deletion: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus user');
        }
    }
}
