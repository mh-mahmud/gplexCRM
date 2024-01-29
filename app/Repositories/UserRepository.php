<?php
namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function listing($request)
    {
        $query = User::select('users.*');
        $query->orderBy('users.created_at','DESC');
        
        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function create(array  $data)
    { 
        $user                 = new User();
        $user->id             = Helper::generateTableId();
        $user->first_name     = $data['first_name'];
        $user->middle_name    = $data['middle_name'] ?? null;
        $user->last_name      = $data['last_name'] ?? null;
        $user->phone          = $data['phone'];
        $user->address        = $data['address'] ?? null;
        $user->user_name      = $data['user_name'];
        $user->email          = $data['email'] ?? null;
        $user->password       = bcrypt($data['password']);
        $user->role_id        = $data['role_id'] ?? null;
        $user->status         = config('constants.ACTIVE');
        $user->save();

        return $user;
    }

    public function show($id)
    {

        return User::findorfail($id);

    }

    public function update(array $data, $id)
    {
        $user                 = User::findorfail($id);
        $user->first_name     = $data['first_name'];
        $user->middle_name    = $data['middle_name'] ?? null;
        $user->last_name      = $data['last_name'] ?? null;
        $user->phone          = $data['phone'];
        $user->address        = $data['address'] ?? null;
        $user->email          = $data['email'] ?? null;
        // $user->password       = bcrypt($data['password']);
        $user->role_id        = $data['role_id'] ?? null;
        $user->save();

        return $user;
    }

    public function delete($id)
    {
        if(User::findorfail($id)->delete()){
            return true;
        }
    }


    public function changePassword(array $data)
    {
        Auth::user()->update([
            'password' => bcrypt($data["password"]),
        ]);
    }

    public function userStatusChange($id)
    {  
        $user = User::findOrFail($id);
        $user->status = ($user->status == config('constants.ACTIVE')) ? config('constants.INACTIVE') : config('constants.ACTIVE');
        $user->save();
        return $user;
    }
}