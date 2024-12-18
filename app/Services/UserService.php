<?php

namespace App\Services;

use App\Mail\SendMailSuporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class UserService extends Service
{
    use WithFileUploads;

    public function list(Array $search_array = [])
    {
        try {
            $search_name = $search_array['search_name'] ?? null;
            $search_role = $search_array['search_role'] ?? null;

            $user_auth = Auth::user();
            /** @disregard [hasAnyRoles] [method in User Model] */
            $user_is_developer = $user_auth->hasAnyRoles('developer');

            $users = User::where(function($query) use($search_name, $search_role, $user_is_developer){
                $query->where('id','>',0);

                if(!$user_is_developer){
                    $query->whereHas('roles', function($q){
                        $q->where('roles.id','<>',1);
                    });
                }

                if(!is_null($search_role) && !empty($search_role)){
                    $query->whereHas('roles', function($q) use($search_role){
                        $q->where('role_id', $search_role);
                    });
                }

                if(!is_null($search_name) && !empty($search_name)){
                    $name_searchArray = explode(' ',$search_name);
                    foreach($name_searchArray as $name_search){
                        $query->where('name', 'like', '%'.$name_search.'%' );
                    }
                }
            })->orderBy('name','asc')->paginate(30);

            return response()->json([
                'error' => false,
                'data' => $users
            ], 200);

        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->UserService->list';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'data' => [],
                'message' => 'Houve um problema ao tentar listar os Usuários, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function store(Array $data)
    {
        try {
            $validator = Validator::make(
                $data, 
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'status' => 'nullable',
                    'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
                    'role_id' => 'required'
                ],
                [
                    'name.required' => 'O Nome é obrigatório',
                    'email.required' => 'O e-mail é obrigatório',
                    'email.email' => 'O e-mail é informado não é válido',
                    'password.required' => 'A senha é obrigatória',
                    'image.mimes' => 'Formato de arquivo não permitido',
                    'image.max' => 'Tamanho máximo para a imagem é de 4MB',
                    'role_id.required' => 'Selecione ao menos uma equipe',
                ]
            );
    
            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }

            $data_store = [
                'name' => $data['name'],
                'status' => $data['status'],
                'password' => Hash::make($data['password'])
            ];
            $image = $data['image'] ?? null;
            if(!is_null($image)){
                $folder ='users';
                $storage_name = 'public';
                $extension  = $image->extension();
                $arrayExtension = [$extension, 'jpg'];
                $fileName = str_replace($arrayExtension, '', $image->getClientOriginalName());
                $fileNameFormated = Str::slug($fileName).'_'.date('His').'.'.$extension;
                $image->storePubliclyAs($folder, $fileNameFormated, $storage_name);
                $data_store['image'] = $fileNameFormated;
            }
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                $data_store
            );


            $role_id = $data['role_id'] ?? [];
            if($user){
                if(is_array($role_id)){
                    $user->roles()->attach($role_id);
                }
            }

            return response()->json([
                'error' => false,
                'data' => $user,
                'message' => 'Usuário adicionado com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->UserService->store';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao registrar do usuário, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function update(User $user, Array $data)
    {
        try {

            $validator = Validator::make(
                $data, 
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'nullable',
                    'status' => 'nullable',
                    'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
                    'role_id' => 'required'
                ],
                [
                    'name.required' => 'O Nome é obrigatório',
                    'email.required' => 'O e-mail é obrigatório',
                    'email.email' => 'O e-mail é informado não é válido',
                    'image.mimes' => 'Formato de arquivo não permitido',
                    'image.max' => 'Tamanho máximo para a imagem é de 4MB',
                    'role_id.required' => 'Selecione ao menos uma equipe',
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }

            $data_store = [
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $data['status']
            ];
            if(!is_null($data['password'])){
                $data_store['password'] = Hash::make($data['password']);
            }
            $image = $data['image'];
            if(!is_null($image)){
                $folder ='users';
                $storage_name = 'public';
                $extension  = $image->extension();
                $arrayExtension = [$extension, 'jpg'];
                $fileName = str_replace($arrayExtension, '', $image->getClientOriginalName());
                $fileNameFormated = Str::slug($fileName).'_'.date('His').'.'.$extension;
                $image->storePubliclyAs($folder, $fileNameFormated, $storage_name);
                $data_store['image'] = $fileNameFormated;
            }
            $user->fill($data_store);
            $user->save();


            if( Gate::allows("manager_system_edit_users") ){
                $role_id = $data['role_id'] ?? [];
                if(is_array($role_id)){
                    $user->roles()->sync($role_id);
                }
            }

            return response()->json([
                'error' => false,
                'data' => $user,
                'message' => 'Usuário atualizado com sucesso!'
            ], 200);

        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->userService->update';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao atualizar o usuário, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function change_status(int $user_id)
    {
        try {
            $user = User::find($user_id);
            if($user){
                $user->status = !$user->status;
                $user->save();
                return response()->json([
                    'error' => false,
                    'data' => $user,
                    'message' => 'Status atualizado com sucesso!'
                ], 200);
            }
            return response()->json([
                'error' => true,
                'message' => 'Usuário não encontrado.'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->userService->change_status';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao atualizar o status do usuário, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function delete_item($user_id)
    {
        try {
            if(!is_numeric($user_id)){
                return response()->json([
                    'error' => true,
                    'message' => 'Registro não encontrado!'
                ], 200);
            }
            User::where('id',$user_id)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Excluído com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->userService->delete_item';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao excluir o usuário, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }
}