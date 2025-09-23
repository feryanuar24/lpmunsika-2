<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use App\Models\Role;
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
        $request->validate([
            'display_name' => ['required', 'string', 'max:255', 'unique:roles,display_name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Role::create([
            'name' => strtolower(str_replace(' ', '_', $request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
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
        $request->validate([
            'display_name' => ['required', 'string', 'max:255', 'unique:roles,display_name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update([
            'name' => strtolower(str_replace(' ', '_', $request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
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
