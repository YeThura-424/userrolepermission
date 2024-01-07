<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// start page of application 
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/category');
    } else {
        return redirect('/login');
    }
});
// Route::get('/', 'App\Http\Controllers\CategoryController@index');
// Route::get('/', function () {
//     return view('auth.login');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function () {
    Route::resource('/category', 'App\Http\Controllers\CategoryController');
    Route::resource('/user', 'App\Http\Controllers\UserController');
    Route::resource('/permission', 'App\Http\Controllers\PermissionController');
    Route::resource('/rolepermission', 'App\Http\Controllers\RolePermissionController');
    Route::resource('/userrolepermission', 'App\Http\Controllers\UserRolePermissionController');
    Route::post('/getrolepermission/{id}', 'App\Http\Controllers\UserRolePermissionController@getRolePermission');
    Route::get('/getrolepermission/{id}', 'App\Http\Controllers\UserRolePermissionController@getRolePermission');
    // Route::post('/search', 'App\Http\Controllers\SearchController@search')->name('search');
    Route::put('/userstatus/{id}', 'App\Http\Controllers\UserController@updateStatus')->name('userstatus');
    Route::get('/search', 'App\Http\Controllers\SearchController@search')->name('search');
    Route::get('/categorysearch', 'App\Http\Controllers\CategoryController@filter')->name('categorysearch');
});
