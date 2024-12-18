<?php

namespace App\Services;

use App\Mail\SendMailSuporte;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleService extends Service
{
    public function list(Array $search_array = [])
    {
        try {
            $search_label = $search_array['search_label'] ?? null;
            $user_auth = Auth::user();
            /** @disregard [hasAnyRoles] [method in User Model] */
            $user_is_developer = $user_auth->hasAnyRoles('developer');
            $roles = Role::where(function($query) use($search_label, $user_is_developer){
                if($user_is_developer)
                    $query->where('id','>',0);
                else
                    $query->where('id','<>',1);

                if(!is_null($search_label) && !empty($search_label)){
                    $name_searchArray = explode(' ',$search_label);
                    foreach($name_searchArray as $name_search){
                        $query->where('label', 'like', '%'.$name_search.'%' );
                    }
                }
            })->orderBy('label','asc')->paginate(30);

            return response()->json([
                'error' => false,
                'data' => $roles
            ], 200);

        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->RoleService->list';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'data' => [],
                'message' => 'Houve um problema ao tentar listar os Grupos de Trabalho, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function store(Array $data)
    {
        try {
            $validator = Validator::make(
                $data, 
                [
                    'name' => [
                        'required',
                        Rule::unique('roles'), 
                    ],
                    'label' => 'required'
                ],
                [
                    'name.required' => 'O Código do Grupo de Trabalho é obrigatório',
                    'name.unique' => 'Já existe um Grupo de Trabalho com esta tag',
                    'label.required' => 'Título de Identificação é obrigatório'
                ]
            );
    
            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }
    
            $role = Role::create($data);
            $permission_id = $data['permission_id'];
            if($role){
                if(is_array($permission_id)){
                    $role->permissions()->attach($permission_id);
                }
            }

            return response()->json([
                'error' => false,
                'data' => $role,
                'message' => 'Grupo de Trabalho adicionada com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->RoleService->store';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao registrar o grupo de trabalho, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function update(Role $role, Array $data)
    {
        try {

            $validator = Validator::make(
                $data, 
                [
                    'name' => [
                        'required',
                        Rule::unique('roles')->ignore($role), 
                    ],
                    'label' => 'required',
                ],
                [
                    'name.required' => 'O código do grupo de trabalho é obrigatório',
                    'name.unique' => 'Já existe um registro com este código',
                    'label.required' => 'O título do grupo de trabalho é obrigatório',
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }

            $role->fill($data);
            $role->save();

            $permission_id = $data['permission_id'] ?? [];
            if(is_array($permission_id)){
                $role->permissions()->sync($permission_id);
            }

            return response()->json([
                'error' => false,
                'data' => $role,
                'message' => 'Grupo de Trabalho atualizado com sucesso!'
            ], 200);

        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->RoleService->update';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao atualizar a permissão, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function delete_item($role_id)
    {
        try {
            if(!is_numeric($role_id)){
                return response()->json([
                    'error' => true,
                    'message' => 'Registro não encontrado!'
                ], 200);
            }
            Role::where('id',$role_id)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Excluído com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->RoleService->delete_item';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao excluir, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }
}