<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Authors extends Model
{
    use HasFactory;

    public function books(): belongsToMany
    {
        return $this->belongsToMany(Books::class, 'books_authors');
    }

    private static function getBooks($id){
        $books = DB::connection("mysql")
        ->table("books as b")
        ->select(
            [
                "b.title",
                "b.date",
                "b.synopsis"
            ]
        )
        ->join('books_authors as ba', function ($join) {
            $join->on('b.id', '=', 'ba.book_id');
        })
        ->join('authors as a', function ($join) {
            $join->on('a.id', '=', 'ba.author_id');
        })
        ->where('a.id', '=', $id)
        ->get();

        return $books;
    }

    private static function getAuthors(){
        $authors = DB::connection("mysql")
        ->table("authors as a")
        ->select([
            "a.*"
        ])
        ->get();

        return $authors;
    }

    public static function getAuthorsWithBooks(){
        $authors = Authors::getAuthors();
    
        foreach($authors as $author){
            $authorModel = new self();
            $author->books = $authorModel->getBooks($author->id);
        }

        return $authors;
    }
}
