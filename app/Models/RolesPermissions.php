<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolesPermissions extends Pivot
{
    protected $table = 'roles_permissions';

    use HasFactory;
}
