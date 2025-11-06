<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'permissions' => Permission::all()
        ];

        return view('pages.permissions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'display_name.required' => 'Nama permission wajib diisi.',
            'display_name.string' => 'Nama permission harus berupa teks.',
            'display_name.max' => 'Nama permission maksimal :max karakter.',
            'display_name.unique' => 'Nama permission sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'display_name' => ['required', 'string', 'max:255', 'unique:permissions,display_name'],
            'description' => ['nullable', 'string', 'max:255'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $validated = $validator->validated();

        Permission::create([
            'name' => strtolower(str_replace(' ', '_', $validated['display_name'])),
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $data = [
            'permission' => $permission
        ];

        return view('pages.permissions.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $data = [
            'permission' => $permission
        ];

        return view('pages.permissions.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $messages = [
            'display_name.required' => 'Nama permission wajib diisi.',
            'display_name.string' => 'Nama permission harus berupa teks.',
            'display_name.max' => 'Nama permission maksimal :max karakter.',
            'display_name.unique' => 'Nama permission sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'display_name' => ['required', 'string', 'max:255', 'unique:permissions,display_name,' . $permission->id],
            'description' => ['nullable', 'string', 'max:255'],
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $validated = $validator->validated();

        $permission->update([
            'name' => strtolower(str_replace(' ', '_', $validated['display_name'])),
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissons.index')->with('success', 'Permission berhasil dihapus.');
    }
}
