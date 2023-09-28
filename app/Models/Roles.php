<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }

    private static function getPermissions($id)
    {
        $permissions = DB::connection('mysql')
        ->table('permissions as p')
        ->select([
            "p.name",
            "p.description",
            "p.resource",
            "p.action"
        ])
        ->join('roles_permissions as rp', function ($join) {
            $join->on('p.id', '=', 'rp.permission_id');
        })
        ->join('roles as r', function ($join) {
            $join->on('r.id', '=', 'rp.role_id');
        })
        ->where('r.id', '=', $id)
        ->get();

        return $permissions;
    }

    private static function getRoles()
    {
        $roles = DB::connection('mysql')
        ->table('roles as r')
        ->select([
            "r.id",
            "r.name",
            "r.description"
        ]) 
        ->get();
        
        return $roles;
    }

    public static function getRolesWithPermissions()
    {
        $roles = Roles::getRoles();

        foreach($roles as $role){
            $rolesModel = new self();
            $role->permissions = $rolesModel->getPermissions($role->id);
        }

        return $roles;
    }
}
