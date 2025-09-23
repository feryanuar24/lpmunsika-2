<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use App\Models\Permission;
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
        $request->validate([
            'display_name' => ['required', 'string', 'max:255', 'unique:permissions,display_name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create([
            'name' => strtolower(str_replace(' ', '_', $request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
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
        $request->validate([
            'display_name' => ['required', 'string', 'max:255', 'unique:permissions,display_name,' . $permission->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update([
            'name' => strtolower(str_replace(' ', '_', $request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
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
