<?php
    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use App\Models\BooksAuthors;
    use App\Models\BooksCategories;
    use App\Models\Books;
    use App\Models\Authors;
    use App\Models\Publishers;
    use App\Models\Categories;

    class BookController extends Controller{
        public function index(){
            $search = request('search');

            $books = Books::getBooksWithAuthors();

            if(!$search){
                return $books;
            }

            $filteredBooks = $books->where([
                ['title', 'like', '%'.$search.'%']
            ]);

            return $filteredBooks;
        }

        public function store(Request $request){
            $bookExists = Books::firstWhere('title', $request->title);

            if(!$bookExists){
                $book = new Books;

                $book->title = $request->title;
                $book->date = $request->date;
                $book->synopsis = $request->synopsis;
                $book->publisher_id = $request->publisher;

                $book->save();

                if($request->authors){
                    foreach($request->authors as $author){
                        $booksAuthors = new BooksAuthors([
                            'author_id' => $author,
                            'book_id' => $book->id
                        ]);
    
                        $booksAuthors->save();
                    }
                }

                if($request->categories){
                    foreach($request->categories as $category){
                        $booksCategories = new BooksCategories([
                            'category_id' => $category,
                            'book_id' => $book->id
                        ]);
    
                        $booksCategories->save();
                    }
                }

                return ['message' => 'Livro adicionado com sucesso!', 'book' => $book];
            }
            
            return ['message' => 'Este livro já existe.'];
        }

        public function update($id, Request $request){
            $book = Books::FindOrFail($id);

            $book->title = $request->title;
            $book->date = $request->date;
            $book->synopsis = $request->synopsis;

            $book->update();

            return ['message' => 'Livro editado com sucesso!'];
        }

        public function destroy($id){
            $book = Books::FindOrFail($id);

            $book->delete();

            return ['message' => 'Livro excluído com sucesso!'];
        }

        public function show($id){
            $book = Books::FindOrFail($id);
            
            return $book;
        }
    }
?>