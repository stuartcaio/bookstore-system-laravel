<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Publishers extends Model
{
    use HasFactory;

    public function books(): belongsTo
    {
        return $this->belongsTo(Books::class);
    }
}
