<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // function __construct()
    // {

    //     $this->middleware('permission: show_permission', ['only' => ['index']]);
    //     $this->middleware('permission: add_permission', ['only' => ['create', 'store']]);
    //     $this->middleware('permission: edit_permission', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission: delete_permission', ['only' => ['destroy']]);
    // }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Vérifiez si l'utilisateur a la permission 'show_permission'
        if (!Gate::allows('show_permission')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('add_permission')) {
            abort(403, 'Unauthorized action.');
        }
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('add_permission')) {
            abort(403, 'Unauthorized action.');
        }
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);

        $role = Role::create(['name' => $request->input('name')]);

        foreach ($request->input('permission') as $permissionId) {
            $permission = Permission::find($permissionId);

            if ($permission) {
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('edit_permission')) {
            abort(403, 'Unauthorized action.');
        }
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('edit_permission')) {
            abort(403, 'Unauthorized action.');
        }
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required|array',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        // Détacher toutes les permissions actuelles du rôle
        $role->permissions()->detach();

        // Attacher les nouvelles permissions sélectionnées
        foreach ($request->input('permission') as $permissionId) {
            $permission = Permission::find($permissionId);

            if ($permission) {
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('delete_permission')) {
            abort(403, 'Unauthorized action.');
        }
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('delete', 'Role deleted successfully');
    }
}
