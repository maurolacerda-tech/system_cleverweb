<?php

namespace App\Services;

use Illuminate\Validation\Rule;
use App\Mail\SendMailSuporte;
use App\Models\Permission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PermissionService extends Service
{
    public function list(Array $search_array = [])
    {
        try {
            $search_label = $search_array['search_label'] ?? null;
            $search_group = $search_array['search_group'] ?? null;
            $permissions = Permission::where(function($query) use($search_label,$search_group){
                $query->where('id','>',0);
                if(!is_null($search_label) && !empty($search_label)){
                    $name_searchArray = explode(' ',$search_label);
                    foreach($name_searchArray as $name_search){
                        $query->where('label', 'like', '%'.$name_search.'%' );
                    }
                }
                if(!is_null($search_group) && !empty(trim($search_group))){
                    $query->where('group_name', $search_group);
                }
            })->orderBy('label','asc')->paginate(30);

            return response()->json([
                'error' => false,
                'data' => $permissions
            ], 200);

        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->PermissionService->list';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'data' => [],
                'message' => 'Houve um problema ao tentar listar as permissões, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function store(Array $data)
    {
        try {
            $validator = Validator::make(
                $data, 
                [
                    'group_name' => 'required',
                    'name' => 'required',
                    'label' => 'required'
                ],
                [
                    'group_name.required' => 'O Grupo é obrigatório',
                    'name.required' => 'O Código da Permissão é obrigatório',
                    'label.required' => 'Título de Identificação é obrigatório'
                ]
            );
    
            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }
    
            $permission = Permission::create($data);
            return response()->json([
                'error' => false,
                'data' => $permission,
                'message' => 'Permissão adicionada com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->PermissionService->store';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao registrar a permissão, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function update(Permission $permission, Array $data)
    {
        try {

            $validator = Validator::make(
                $data, 
                [
                    'name' => [
                        'required',
                        Rule::unique('permissions')->ignore($permission), 
                    ],
                    'label' => 'required',
                    'group_name' => 'required',
                ],
                [
                    'name.required' => 'O código da permissão é obrigatório',
                    'name.unique' => 'Já existe um registro com este código',
                    'label.required' => 'O título da permissão é obrigatório',
                    'group_name.required' => 'O grupo da permissão é obrigatório',
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }

            $permission->fill($data);
            $permission->save();
            return response()->json([
                'error' => false,
                'data' => $permission,
                'message' => 'Permissão atualizada com sucesso!'
            ], 200);

        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->PermissionService->update';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao atualizar a permissão, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }
}