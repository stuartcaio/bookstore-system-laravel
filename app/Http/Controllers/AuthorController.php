<?php
    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use App\Models\Authors;

    class AuthorController extends Controller{
        public function index(Request $request) {
            $search = $request->input('search');

            $authors = Authors::getAuthorsWithBooks();

            if(!$search){
                return $authors;
            }
            
            $filteredAuthors = $authors->where([
                ['name', 'like', '%'.$search.'%']
            ])->get();

            return $filteredAuthors;
        }

        public function store(Request $request){
            $authorExists = Authors::firstWhere('name', $request->name);

            if(!$authorExists){
                $author = new Authors;

                $author->name = $request->name;
                $author->dateOfBirth = $request->dateOfBirth;
    
                $author->save();

                return ['message' => 'Autor adicionado com sucesso!', 'author' => $author];
            }
            
            return ['message' => 'Este autor já existe'];
        }

        public function update($id, Request $request){
            $author = Authors::FindOrFail($id);

            $author->name = $request->name;
            $author->dateOfBirth = $request->dateOfBirth;

            $author->update();

            return ['message' => 'Autor editado com sucesso!'];
        }

        public function destroy($id){
            $author = Authors::FindOrFail($id);

            $author->delete();

            return ['message' => 'Autor excluído com sucesso!'];
        }

        public function show($id){
            $author = Authors::FindOrFail($id);

            return $author;
        }
    }
?>