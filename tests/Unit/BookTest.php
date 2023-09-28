<?php
    namespace Tests\Unit;

    use PHPUnit\Framework\TestCase;
    use Illuminate\Support\Facades\DB;
    use Tests\Unit\Book;

    class BookTest extends TestCase{
        public function test_book()
        {
            $book = new Book('The Lord of The Rings', '14/02/1940', 'A book writted by J.R.R Tolkien');
            $this->assertEquals("Título: The Lord of The Rings; Data de Lançamento: 14/02/1940; Descrição: A book writted by J.R.R Tolkien", $book->getMessage());
        }
    }
?>