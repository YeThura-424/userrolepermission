<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer(
        //     '*',
        //     function ($view) {
        //         $permissions = Permission::all();
        //         // dd($permissions);
        //         foreach ($permissions as $permission) {
        //             // dd($permission);
        //             $permission_id = $permission->id;
        //             // dd($permission_id);
        //             if (Auth::check()) {
        //                 $user = Auth::user();
        //                 // dd($user);
        //                 $user_id = $user->id;
        //                 // dd($user_id);
        //                 $categoryPermissions = DB::table('model_has_permissions')->where([
        //                     ['model_id', $user_id],
        //                     ['permission_id', $permission_id]
        //                 ])->get();
        //                 // dd($categoryPermissions);
        //                 $view->with('data', $categoryPermissions);
        //             }
        //         }
        //     }
        // );
    }
}
