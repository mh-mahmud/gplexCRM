<?php
namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
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
        $user->role_id = $request->role_id;
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
        return Menu::paginate(100);
    }

    public function get_parent_list() {
        return Menu::whereNull('parent_id')->get(['id', 'name']);
    }

    public function create_permission($request) {

        $data = Menu::create([
            'name' => $request->name,
            'sub_name' => $request->slug,
            'show_in_menu' => $request->show_in_menu,
            'parent_id' => !empty($request->parent_id) ? $request->parent_id : null
        ]);
        $data->save();
        return $data;
    }

    public function edit_permission($request) {

        $user = Menu::findOrFail($request->id);
        $user->name = $request->name;
        $user->sub_name = $request->slug;
        $user->show_in_menu = $request->show_in_menu;
        $user->parent_id = !empty($request->parent_id) ? $request->parent_id : null;
        if($user->save()) {
            return true;
        }
        return false;
    }

    public function show_permission($id) {
        return Menu::findOrFail($id);
    }

    public function delete_permission($id) {
        $user = Menu::findOrFail($id);
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

    public function menu_list() {
        $data = [];
        $menus = Menu::where('parent_id', '=', null)->get(['id', 'name', 'show_in_menu', 'status']);
        foreach($menus as $key=>$val) {
            $name = str_replace(" ", "_", $val->name);
            $data[$name] = Menu::where('parent_id', $val->id)->get(['id', 'parent_id', 'name', 'sub_name', 'show_in_menu', 'status']);
        }
        return $data;
    }

    public function create_role_data($request) {
        // dd($request->all());

        $role_name = $request->role_name;
        $all_req = $request->all();

        unset($all_req['role_name']);
        unset($all_req['_token']);
        $data_set = [];

        foreach($all_req as $key=>$val) {
            for($i=0; $i<count($val); $i++) {
                $menu_details = Menu::where('id', $val[$i])->first(['name','sub_name']);
                $data_set[$key][$menu_details->sub_name] = $menu_details->name;
            }
        }

        $json_data = json_encode($data_set);
        /*dd($json_data);
        $json_data = json_encode($all_req);*/

        $role = Role::create([
            'name' => $role_name,
            'permission_details' => $json_data,
            'slug' => strtolower(str_replace(" ", "_", $role_name)),
            'status' => 1
        ]);
        //dd($json_data);
        $role->save();
        return $role;
    }

    public function get_all_role_name() {
        $send = [];
        $data = Role::all(['id', 'name']);
        foreach($data as $key=>$value) {
            $send[$value->id] = $value->name;
        }
        return $send;
    }
}