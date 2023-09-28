<?php 
    namespace App\Http\Controllers;

    use App\Models\Categories;
    use Illuminate\Http\Request;

    class CategoryController extends Controller{
        public function index(){
            $search = request('search');

            if(!$search){
                $categories = Categories::all();

                return $categories;
            }
            
            $filteredSearch = Categories::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();

            return $filteredSearch;
        }

        public function store(Request $request){
            $categoryExists = Categories::firstWhere('name', $request->name);

            if(!$categoryExists){
                $category = new Categories;

                $category->name = $request->name;
    
                $category->save();
    
                return ['message' => 'Categoria adicionada com sucesso!'];
            }
            
            return ['message' => 'Esta categoria já existe.'];
        }

        public function update($id, Request $request){
            $category = Categories::FindOrFail($id);

            $category->name = $request->name;
            
            $category->update();

            return ['message' => 'Categoria atualizada com sucesso!'];
        }

        public function destroy($id){
            $category = Categories::FindOrFail($id);

            $category->delete($id);

            return ['message' => 'Categoria deletada com sucesso!'];
        }

        public function show($id){
            $category = Categories::FindOrFail($id);

            return $category;
        }
    }
?>