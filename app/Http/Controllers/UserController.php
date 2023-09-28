<?php
    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Tymon\JWTAuth\Facades\JWTAuth;
    use Illuminate\Auth\SessionGuard;
    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\UsersRoles;

    class UserController extends Controller{
        private function setRoles($roles, $user){
            if($roles){
                foreach($roles as $role){
                    $userRole = new UsersRoles([
                        'role_id' => $role,
                        'user_id' => $user->id
                    ]);
    
                    $userRole->save();
                }
            }
        }

        public function index(){
            $search = request('search');

            if(!$search){
                $users = User::getUsersWithRoles();

                return $users;
            }
            
            $filteredUsers = User::where([
                ['name', 'like', '%'.$search.'%']
            ])
            ->orWhere([
                ['email', 'like', '%'.$search.'%']
            ])
            ->orWhere([
                ['password', 'like', '%'.$search.'%']
            ])
            ->get();

            return $filteredUsers;
        }

        public function store(Request $request){
            $userExists = User::firstWhere('email', $request->email);

            if(!$userExists){
                $user = new User;

                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password;
    
                $user->save();

                $this->setRoles($request->roles, $user);
    
                return ['message' => 'Usuário adicionado com sucesso!'];
            }
            
            return ['message' => 'Este usuário já existe.'];
        }

        public function update($id, Request $request){
            $user = User::FindOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;

            $user->update();

            $this->setRoles($request->roles, $user);

            return ['message' => 'Usuário atualizado com sucesso!'];
        }

        public function destroy($id){
            $user = User::FindOrFail($id);

            $user->delete();

            return ['message' => 'Usuário deletado com sucesso!'];
        }

        public function show($id){
            $user = User::FindOrFail($id);
            
            return $user;
        }

        public function login(Request $request){
            $adminUsers = $this->adminUsers;

            if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return ['message' => 'E-mail ou senha incorretos.'];
            }

            $user = Auth::user();

            foreach($adminUsers as $adminUser){
                if($adminUser['email'] === $request->email && $adminUser['password'] === $request->password){
                    $token = JWTAuth::fromUser($user, ['role' => 'admin']);

                    return ['message' => 'Administrador logado com sucesso!', 'token' => $token];
                }
            }

            $token = JWTAuth::fromUser($user);

            return ['message' => 'Usuário logado com sucesso!', 'token' => $token];
        }

        public function logout(Request $request){
            Auth::logout();

            return ['message' => 'Usuário deslogado com sucesso!'];
        }

        public function refresh(){
            $token = Auth::refresh();

            return ['message' => 'Token atualizado com sucesso!', 'token' => $token];
        }
    }
?>