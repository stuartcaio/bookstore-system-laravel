<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWtSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getRoles($id){
        $roles = DB::connection('mysql')
        ->table('roles as r')
        ->select([
            "r.id",
            "r.name",
            "r.description"
        ])
        ->join('users_roles as ur', function ($join) {
            $join->on('r.id', '=', 'ur.role_id');
        })
        ->join('users as u', function ($join) {
            $join->on('u.id', '=', 'ur.user_id');
        })
        ->where('u.id', '=', $id)
        ->get();

        return $roles;
    }

    private static function getUsers()
    {
        $users = DB::connection('mysql')
        ->table('users as u')
        ->select([
            "u.id",
            "u.name",
            "u.email",
        ])
        ->get();

        return $users;
    }

    public static function getUsersWithRoles()
    {
        $users = User::getUsers();

        foreach($users as $user){
            $usersModel = new self();
            $user->roles = $usersModel->getRoles($user->id);
        }

        return $users;
    }
}
