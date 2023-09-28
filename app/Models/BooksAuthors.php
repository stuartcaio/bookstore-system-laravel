<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BooksAuthors extends Pivot
{
    protected $table = 'books_authors';

    use HasFactory;
}
