<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use App\Models\Role;
use Auth;
use Session;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'user_id',
        'status',
        'gender',
        'address',
        'profile_image',
        'password',
        'user_type',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userRole()
    {

        return $this->hasMany(UsersRole::class);

    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function get_menu_data() {
        /*if(Auth::user()->user_type=='admin') {
            return;
        }*/

        $ses_name = 'user_menu_data_' . Auth::user()->role_id;

        if(!empty(Session::get($ses_name))) {
            return Session::get($ses_name);
        }
        else {
            $role_data = Role::where('id', Auth::user()->role_id)->first(['name', 'permission_details']);
            if(!empty($role_data)) {
                Session::put($ses_name, $role_data->permission_details);
                return $role_data->permission_details;
            }
        }

        return null;
    }

    public function hasPermission_rokib($permission)
    {
        //users role permission details (JSON format data)
        $permission_details = $this->get_menu_data();

        if ($permission_details) {
            $permissions = json_decode($permission_details, true);
            //chk if the requested permission exists in the users permissions
            return in_array($permission, $permissions);
        }

        return false;
    }


    
    public function hasPermission($permission) {
        $ses_name = 'user_menu_data_' . Auth::user()->role_id;
        $get_sess =  Session::get($ses_name);
        dd($get_sess);
    }
    
}
