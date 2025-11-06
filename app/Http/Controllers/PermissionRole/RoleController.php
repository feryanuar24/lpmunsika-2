<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'roles' => Role::all()
        ];

        return view('pages.roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'display_name.required' => 'Nama role wajib diisi.',
            'display_name.string' => 'Nama role harus berupa teks.',
            'display_name.max' => 'Nama role maksimal :max karakter.',
            'display_name.unique' => 'Nama role sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'display_name' => ['required', 'string', 'max:255', 'unique:roles,display_name'],
            'description' => ['nullable', 'string', 'max:255'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $validated = $validator->validated();

        Role::create([
            'name' => strtolower(str_replace(' ', '_', $validated['display_name'])),
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $data = [
            'role' => $role,
        ];

        return view('pages.roles.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $data = [
            'role' => $role,
        ];

        return view('pages.roles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $messages = [
            'display_name.required' => 'Nama role wajib diisi.',
            'display_name.string' => 'Nama role harus berupa teks.',
            'display_name.max' => 'Nama role maksimal :max karakter.',
            'display_name.unique' => 'Nama role sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'display_name' => ['required', 'string', 'max:255', 'unique:roles,display_name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $validated = $validator->validated();

        $role->update([
            'name' => strtolower(str_replace(' ', '_', $validated['display_name'])),
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
