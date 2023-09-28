<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\RolesPermissions;

class RoleController extends Controller
{
    private function setPermissions($permissions, $role){
        if($permissions){
            foreach($permissions as $permission){
                $rolePermission = new RolesPermissions([
                    'permission_id' => $permission,
                    'role_id' => $role->id
                ]);

                $rolePermission->save();
            }
        }
    }

    public function index(){
        try{
            $roles = Roles::getRolesWithPermissions();

            return $roles;
        } catch(Exception $e){
            return response()->json(['error' => $e]);
        }
    }

    public function store(Request $request){
        $rolesExists = Roles::firstWhere('name', $request->name);

        if(!$rolesExists){
            $role = new Roles;

            $role->name = $request->name;
            $role->description = $request->description;

            $role->save();

            $this->setPermissions($request->permissions, $role);

            return ['message' => 'Cargo criado com sucesso!', 'role' => $role];
        }

        return ['message' => 'Este cargo já existe.'];
    }

    public function update(Request $request, $id){
        $role = Roles::FindOrFail($id);

        if(!$role){
            return ['message' => 'Este cargo não existe.'];
        }

        $role->name = $request->name;
        $role->description = $request->description;

        $role->update();

        $this->setPermissions($request->permissions, $role);

        return ['message' => 'Cargo atualizado com sucesso!'];
    }

    public function destroy($id){
        $role = Roles::FindOrFail($id);

        if(!$role){
            return ['message' => 'Este cargo não existe.'];
        }

        $role->delete();

        return ['message' => 'Cargo excluído com sucesso!'];
    }

    public function show($id){
        $role = Roles::FindOrFail($id);

        if(!$role){
            return ['message' => 'Este cargo não existe.'];
        }

        return $role;
    }
}
