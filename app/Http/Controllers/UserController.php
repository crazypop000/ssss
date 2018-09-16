<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller
{
    public function index(Request $request) {
    	$users = User::get()->load('roles');
    	return $users;
    }

    public function create(Request $request) {
    	$data = $request->input('user');
    	$user = new User();
    	$user->name = $data['name'];
    	$user->email = $data['email'];
    	$user->password = bcrypt($data['password']);
    	$role  = Role::where('name', $data['role'])->first();
    	
    	$user->save();

    	$user->roles()->attach($role);
    	return response('success');
    }

    public function edit(Request $request) {
    	$data = $request->input('user');
    	$user = User::find($data['id']);
    	$user->name = $data['name'];
    	$user->email = $data['email'];

    	$role_input_name = $data['roles'][0]['name'];
    	$role = Role::where('name', '=', $role_input_name)->first();
    	
    	$user->roles()->detach($data['roles'][0]['id']); // Detach VIP role
	    $user->roles()->attach($role->id);

    	$user->save();
    	return 'success';
    }
}
