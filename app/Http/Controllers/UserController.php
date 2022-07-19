<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::all();
		return view('backend.user.list', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('backend.user.new');
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
			'profile' => 'required|mimes:jpeg,bmp,png,jpg',
			'first_name' => ['required', 'string', 'max:255', 'unique:users'],
			'last_name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'max:255', 'unique:users'],
			'username' => ['required', 'string', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'max:255', 'unique:users'],
			'phone' => ['required', 'string', 'max:255', 'unique:users'],
			'address' => ['required', 'string', 'max:255', 'unique:users'],
		]);

		if ($validator) {
			$profile = $request->profile;
			$first_name = $request->first_name;
			$last_name = $request->last_name;
			$email = $request->email;
			$username = $request->username;
			$password = $request->password;
			$phone = $request->phone;
			$address = $request->address;

			//File Upload

			$imageName = time() . '.' . $profile->extension();
			$profile->move(public_path('images/user'), $imageName);
			$filepath = 'images/user/' . $imageName;

			//Data Insert

			$user = new User;
			$user->profile = $filepath;
			$user->first_name = $first_name;
			$user->last_name = $last_name;
			$user->email = $email;
			$user->username = $username;
			$user->password = Hash::make($password);
			$user->phone = $phone;
			$user->address = $address;
			$user->save();

			return redirect()->route('user.index')->with('successMsg', 'New User is ADDED in your data');
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
		$user = User::find($id);
		return view('backend.user.edit', compact('user'));
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
		$profile = $request->profile;
		$oldprofile = $request->oldProfile;
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$username = $request->username;
		$password = $request->password;
		$phone = $request->phone;
		$address = $request->address;

		if ($request->hasFile('profile')) {
			$imageName = time() . '.' . $profile->extension();
			$profile->move(public_path('images/user'), $imageName);
			$filepath = 'images/user/' . $imageName;
			if (\File::exists(public_path($oldprofile))) {
				\File::delete(public_path($oldprofile));
			}
		} else {
			$filepath = $oldprofile;
		}

		$user = User::find($id);
		$user->profile = $filepath;
		$user->first_name = $first_name;
		$user->last_name = $last_name;
		$user->email = $email;
		$user->username = $username;
		$user->phone = $phone;
		$user->address = $address;
		$user->save();
		return redirect()->route('user.index')->with('successMsg', 'Existing User is UPDATED in your database');
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
		$user->delete();

		return redirect()->route('user.index')->with('successMsg', 'Existing User is DELETED in your database');
	}

	public function updateStatus($id)
	{
		//

		// dd($id);
		$user = User::find($id);
		// dd($user);
		$user->status = 0;
		$user->save();

		return redirect()->route('user.index')->with('successMsg', 'Existing User Status has been changed');
	}
}
