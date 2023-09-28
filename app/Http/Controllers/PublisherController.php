<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Publishers;

    class PublisherController extends Controller{
        public function index(){
            $search = request('search');

            if(!$search){
                $publishers = Publishers::all();

                return $publishers;
            } 
            
            $filteredPublishers = Publishers::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
            
            return $filteredPublishers;
        }

        public function store(Request $request){
            $publisherExists = Publishers::firstWhere('name', $request->name);

            if(!$publisherExists){
                $publisher = new Publishers;

                $publisher->name = $request->name;
    
                $publisher->save();
    
                return ['message' => 'Editora cadastrada com sucesso!'];
            }
            
            return ['message' => 'Esta editora já existe.'];
        }

        public function update(Request $request, $id){
            $publisher = Publishers::FindOrFail($id);

            $publisher->name = $request->name;

            $publisher->update();

            return ['message' => 'Editora atualizada com sucesso!'];
        }

        public function destroy($id){
            $publisher = Publishers::FindOrFail($id);

            $publisher->delete();

            return ['message' => 'Editora excluída com sucesso!'];
        }

        public function show($id){
            $publisher = Publishers::FindOrFail($id);
        
            return $publisher;
        }
    }
?>