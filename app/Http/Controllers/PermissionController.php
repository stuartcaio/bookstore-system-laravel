<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permissions::all();

        return $permissions;
    }

    public function store(Request $request){
        $permissionsExists = Permissions::firstWhere('name', $request->name);

        if(!$permissionsExists){
            $permission = new Permissions;

            $permission->name = $request->name;
            $permission->description = $request->description;
            $permission->resource = $request->resource;
            $permission->action = $request->action;

            $permission->save();

            return ['message' => 'Permissão criada com sucesso!', 'permission' => $permission];
        }

        return ['message' => 'Esta permissão já existe.'];
    }

    public function update(Request $request, $id){
        $permission = Permissions::FindOrFail($id);

        if(!$permission){
            return ['message' => 'Esta permissão não existe.'];
        }

        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->resource = $request->resource;
        $permission->action = $request->action;

        $permission->update();

        return ['message' => 'Permissão atualizada com sucesso!'];
    }

    public function destroy($id){
        $permission = Permissions::FindOrFail($id);

        if(!$permission){
            return ['message' => 'Esta permissão não existe.'];
        }

        $permission->delete();

        return ['message' => 'Permissão excluída com sucesso!'];
    }

    public function show($id){
        $permission = Permissions::FindOrFail($id);

        if(!$permission){
            return ['message' => 'Esta permissão não existe.'];
        }

        return $permission;
    }
}
