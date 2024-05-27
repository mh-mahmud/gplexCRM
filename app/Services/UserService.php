<?php
namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\SmsQueue;
use App\Models\SmsLog;
use Exception;

class UserService {

	public function get_all_user() {
		return User::paginate(10);
	}

    public function get_all_role() {
        return Role::paginate(10);
    }

    public function create_user($request) {

        $user = User::create([
            'user_id' => str_pad(mt_rand(1, 9999999999999), 20),
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_type' =>'user',
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);
        $user->save();
        return $user;
    }

    public function show_user($id) {
        return User::findOrFail($id);
    }

    public function edit_user($request) {
        $user = User::findOrFail($request->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        if(!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->status = $request->status;
        $user->address = $request->address;
        if($user->save()) {
                return true;
        }
        return false;
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        if($user->delete()) {
            return true;
        }
        return false;
    }

    public function get_all_permission() {
        return Permission::paginate(100);
    }

    public function get_parent_list() {
        return Permission::whereNull('parent_id')->get(['id', 'name']);
    }

    public function create_permission($request) {

        $data = Permission::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'show_in_menu' => $request->show_in_menu,
            'parent_id' => !empty($request->parent_id) ? $request->parent_id : null
        ]);
        $data->save();
        return $data;
    }

    public function edit_permission($request) {

        $user = Permission::findOrFail($request->id);
        $user->name = $request->name;
        $user->slug = $request->slug;
        $user->show_in_menu = $request->show_in_menu;
        $user->parent_id = !empty($request->parent_id) ? $request->parent_id : null;
        if($user->save()) {
                return true;
        }
        return false;
    }

    public function show_permission($id) {
        return Permission::findOrFail($id);
    }

    public function delete_permission($id) {
        $user = Permission::findOrFail($id);
        if($user->delete()) {
            return true;
        }
        return false;
    }

    public function delete_role($id) {
        $user = Role::findOrFail($id);
        if($user->delete()) {
            return true;
        }
        return false;
    }
}