<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsersRoles extends Pivot
{
    protected $table = 'users_roles';

    use HasFactory;
}
