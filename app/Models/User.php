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
        'email',
        'phone_number',
        'user_id',
        'status',
        'gender',
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
        $role_data = Role::where('id', Auth::user()->role_id)->first(['name', 'permission_details']);
        if(!empty($role_data)) {
            return $role_data->permission_details;
        }
        return null;
    }
}
