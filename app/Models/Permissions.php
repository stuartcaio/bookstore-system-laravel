<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permissions extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_permissions');
    }

    public function permissions()
    {
        $permissions = DB::connection('mysql')
        ->table('permissinos as p')
        ->select([
            "p.name",
            "p.description",
            "p.resource",
            "p.action"
        ])
        ->get();

        return $permissions;
    }
}
