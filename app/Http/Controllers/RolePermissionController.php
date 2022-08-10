<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.rolepermission.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        // dd($permissions);
        return view('backend.rolepermission.new', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $rolename = $request->name;
        $role = new Role;
        $role->name = $rolename;
        $role->save();

        $permissions_name = $request->permissionname;
        $permission_id = $request->permission_id;
        $creates = $request->create;
        $reads = $request->read;
        $updates = $request->update;
        $deletes = $request->delete;

        foreach ($permission_id as $id) {
            $permission = $permissions_name[$id];
            $create = $creates[$id];
            $read = $reads[$id];
            $update = $updates[$id];
            $delete = $deletes[$id];
            if ($create == 'yes' || $read == 'yes' || $update == 'yes' || $delete == 'yes') {
                $role->permissions()->attach($id, [
                    'create' => $create,
                    'read' => $read,
                    'update' => $update,
                    'delete' => $delete
                ]);
            }
        }

        return redirect()->route('rolepermission.index')->with("successMsg", 'New RolePermission is ADDED in your database');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $role = Role::find($id);
        $permissions = Permission::all();
        $rolepermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id')->all();
        $create = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.create', 'role_has_permissions.permission_id')->all();
        $read = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.read', 'role_has_permissions.permission_id')->all();
        $update = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.update', 'role_has_permissions.permission_id')->all();
        $delete = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.delete', 'role_has_permissions.permission_id')->all();
        // dd($rolepermissions, $create);



        return view('backend.rolepermission.edit', compact('role', 'permissions', 'rolepermissions', 'create', 'update', 'read', 'delete'));
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
        // dd($id);
        // dd($request);
        $name = $request->name;
        $role = Role::find($id);
        $role->name = $name;
        $role->save();

        $permissions_name = $request->permissionname;
        $permission_ids = $request->permission_id;
        $creates = $request->create;
        $reads = $request->read;
        $updates = $request->update;
        $deletes = $request->delete;

        // dd($creates, $reads, $updates, $deletes, $permission_id);

        foreach ($permission_ids as $ids) {
            $permission_id = $permission_ids[$ids];
            $create = $creates[$ids];
            $read = $reads[$ids];
            $update = $updates[$ids];
            $delete = $deletes[$ids];
            if ($create == 'yes' || $read == 'yes' || $update == 'yes' || $delete == 'yes') {
                DB::table('role_has_permissions')->where([
                    ['role_id', $id],
                    ['permission_id', $permission_id]
                ])->update([
                    // 'permission_id' => $permission_id,
                    'create' => $create,
                    'read' => $read,
                    'update' => $update,
                    'delete' => $delete,
                ]);
            }
        }
        return redirect()->route('rolepermission.index')->with("successMsg", 'Existing RolePermission is UPDATED in your database');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $role = Role::find($id);
        $role->delete();

        return redirect()->route('rolepermission.index')->with("successMsg", 'Existing RolePermission is DELETED from your database');
    }
}
