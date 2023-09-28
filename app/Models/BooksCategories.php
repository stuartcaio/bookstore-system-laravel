<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BooksCategories extends Pivot
{
    protected $table = 'books_categories';

    use HasFactory;
}
