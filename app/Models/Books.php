<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Books extends Model
{
    use HasFactory;

    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'books_authors');
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'books_categories');
    }

    public function publisher(): hasOne
    {
        return $this->hasOne(Publishers::class);
    }

    private static function getAuthors($id){
        $authors = DB::connection('mysql')          
        ->table('authors as a')
        ->select([
            "a.name"
        ])
        ->join('books_authors as ba', function ($join) {
            $join->on('a.id', '=', 'ba.author_id');
        })
        ->join('books as b', function ($join) {
            $join->on('b.id', '=', 'ba.book_id');
        })
        ->where('b.id', '=', $id)
        ->get();

        return $authors;
    }

    private static function getBooks(){
        $books = DB::connection('mysql')
        ->table('books as b')
        ->select([
            "b.*"
        ])
        ->get();

        return $books;
    }

    public static function getBooksWithAuthors(){
        $books = Books::getBooks();

        foreach($books as $book){
            $booksModel = new self();
            $book->authors = $booksModel->getAuthors($book->id);
        }

        return $books;
    }
}
