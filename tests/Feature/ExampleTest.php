<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Books;
use Illuminate\Support\Facades\DB;

class ExampleTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    public function test_books_has_authors(){
        $books = Books::getBooksWithAuthors();

        foreach($books as $book){
            $this->assertObjectHasProperty('authors', $book);
        }
    }

    // public function test_books(){
    //     $book = new Books;

    //     $book->title = 'Dune';
    //     $book->date = '14/02/1960';
    //     $book->synopsis = 'A book writted by Frank Hebert';
    //     $book->publisher_id = 1;

    //     $book->save();

    //     DB::rollBack();
    // }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }
}
