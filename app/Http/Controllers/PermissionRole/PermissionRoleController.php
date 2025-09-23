<?php

namespace App\Http\Controllers\PermissionRole;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission_role = DB::table('permission_role')
            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
            ->join('roles', 'permission_role.role_id', '=', 'roles.id')
            ->select('permission_role.*', 'permissions.name as permission_name', 'roles.name as role_name')
            ->get();

        $data = [
            'permission_role' => $permission_role,
        ];

        return view('pages.permission-role.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        $roles = Role::all();

        $data = [
            'permissions' => $permissions,
            'roles' => $roles,
        ];

        return view('pages.permission-role.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $permission = Permission::find($request->permission_id);
        $role = Role::find($request->role_id);
        $role->givePermission($permission);

        return redirect()->route('permission-role.index')->with('success', 'Permission berhasil ditambahkan ke role.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $permission_id = $request->permission_id;
        $role_id = $request->role_id;

        $permission = Permission::find($permission_id);
        $role = Role::find($role_id);
        $role->removePermission($permission);

        return redirect()->route('permission-role.index')->with('success', 'Permission berhasil dihapus dari role.');
    }
}
