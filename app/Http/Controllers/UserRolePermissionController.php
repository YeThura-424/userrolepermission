<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;



class UserRolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userroles = DB::table('model_has_roles')->get();
        // dd($userroles);
        $users = User::all();
        // $roles = $users->getRoleNames();
        // dd($roles);
        return view('backend.userrolepermission.list', compact('users', 'userroles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('backend.userrolepermission.new', compact('permissions', 'roles', 'users'));
    }

    public function getRolePermission($id)
    {
        // dd($id);
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
        $permissions = Permission::all();

        return response()->json([
            'permission' => $permissions,
            'rolepermission' => $rolepermissions,
            'create' => $create,
            'read' => $read,
            'update' => $update,
            'delete' => $delete
        ]);
        // return view('backend.userrolepermission.new', compact('rolepermissions', 'create', 'read', 'update', 'delete'));
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
        $validator = $request->validate([
            'roleid' => 'required|numeric',
            'userid' => 'required|numeric|min:0|not_in:0'
        ], [
            'roleid.numeric' => 'Please select Role Name first',
            'userid.numeric' => 'Please select User Name first'
        ]);
        if ($validator) {
            $roleid = $request->roleid;
            $userid = $request->userid;
            $user = User::find($userid);
            $role = Role::all()->pluck('name')->toArray();
            if ($user->hasAnyRole($role)) {
                return redirect::back()->with("errorMsg", "The current user has already has a role, Please Update!");
            } else {
                $user->assignRole($roleid);
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
                        $user->permissions()->attach($id, [
                            'create' => $create,
                            'read' => $read,
                            'update' => $update,
                            'delete' => $delete
                        ]);
                    }
                }
                return redirect()->route('userrolepermission.index')->with("successMsg", 'New UserRolePermission is ADDED in your database');
            }
        } else {
            return redirect::back()->withErrors($validator);
        }


        // dd($user);


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
        $user = User::find($id);
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $userpermissions = DB::table("model_has_permissions")->where("model_has_permissions.model_id", $id)
            ->pluck('model_has_permissions.permission_id')->all();
        $create = DB::table("model_has_permissions")->where("model_has_permissions.model_id", $id)
            ->pluck('model_has_permissions.create', 'model_has_permissions.permission_id')->all();
        $read = DB::table("model_has_permissions")->where("model_has_permissions.model_id", $id)
            ->pluck('model_has_permissions.read', 'model_has_permissions.permission_id')->all();
        $update = DB::table("model_has_permissions")->where("model_has_permissions.model_id", $id)
            ->pluck('model_has_permissions.update', 'model_has_permissions.permission_id')->all();
        $delete = DB::table("model_has_permissions")->where("model_has_permissions.model_id", $id)
            ->pluck('model_has_permissions.delete', 'model_has_permissions.permission_id')->all();
        // dd($userpermissions, $create);
        return view('backend.userrolepermission.edit', compact('user', 'users', 'roles', 'permissions', 'userpermissions', 'create', 'update', 'read', 'delete'));
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
        // dd($request);
        // dd($id);
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
            if (
                $create == 'yes' || $read == 'yes' || $update == 'yes' || $delete == 'yes'
            ) {
                DB::table('model_has_permissions')->where([
                    ['model_id', $id],
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
        return redirect()->route('userrolepermission.index')->with("successMsg", 'Existing UserRolePermission is UPDATED in your database');
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
        $user = User::find($id);
        $userrole = implode($user->getRoleNames()->toArray());
        // dd($userrole);
        $user->removeRole($userrole);
        $userpermissions = $user->getAllPermissions();
        // dd($userpermission);
        foreach ($userpermissions as $userpermission) {
            $permission_id = $userpermission->id;
            // dd($permission_id);
            DB::table('model_has_permissions')->where([
                ['model_id', $id],
                ['permission_id', $permission_id]
            ])->delete();
        }
        return redirect()->route('userrolepermission.index')->with("successMsg", 'Existing UserRolePermission is DELETED from your database');
    }
}
