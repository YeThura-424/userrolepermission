<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Permission;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    class PermissionController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $permissions = Permission::where('name', 'Permission')->get();
            foreach ($permissions as $permission) {
                $permission_id = $permission->id;
            }
            $user = Auth::user();
            $user_id = $user->id;
            $permissionPermissions = DB::table('model_has_permissions')->where([
                ['model_id', $user_id],
                ['permission_id', $permission_id]
            ])->get();
            // dd($permissionPermissions);
            $permissions = Permission::all();
            return view('backend.permission.list', compact('permissions', 'permissionPermissions'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('backend.permission.new');
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
                'name' => ['required', 'string', 'max:255', 'unique:permissions']
            ]);

            if ($validator) {
                $name = $request->name;

                $permission = new Permission;
                $permission->name = $name;
                $permission->save();

                return redirect()->route('permission.index')->with("successMsg", 'New Permission is ADDED in your database');
            } else {
                return redirect::back()->withErrors($validator);
            }
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
            $permissions = Permission::where('name', 'Permission')->get();
            foreach ($permissions as $permission) {
                $permission_id = $permission->id;
            }
            $user = Auth::user();
            $user_id = $user->id;
            $permissionPermissions = DB::table('model_has_permissions')->where([
                ['model_id', $user_id],
                ['permission_id', $permission_id]
            ])->get();
            // dd($permissionPermissions);
            $permission = Permission::find($id);
            // dd($id);
            return view('backend.permission.edit', compact('permission', 'permissionPermissions'));
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
            // dd($request, $id);
            $name = $request->name;

            $permission = Permission::find($id);
            $permission->name = $name;
            $permission->save();

            return redirect()->route('permission.index')->with('successMsg', 'Existing Permission is UPDATED in your database');
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
            $permission = Permission::find($id);
            $permission->delete();

            return redirect()->route('permission.index')->with('successMsg', 'Existing Permission is DELETED in your database');
        }
    }
