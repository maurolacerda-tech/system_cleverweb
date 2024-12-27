<?php

namespace App\Livewire\Panel;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Permission;
use App\Services\PermissionService;

class PermissionsEdit extends Component
{

    public $page_title = 'Permissões';
    public $page_subtitle = [];

    public $query = '';
    public $group_list;

    public $permission;

    public $group_name = '';
    public $name = '';
    public $label = '';

    public function mount(Permission $permission)
    {
        $this->group_list = Permission::GROUP_LIST;
        $this->page_subtitle = [
            [
                'name' => 'Gerenciamento',
                'class' => 'text-muted'
            ],
            [
                'name' => 'Perfis de acesso',
                'class' => 'text-muted'
            ],
            [
                'name' => 'Permissões',
                'class' => 'text-muted',
                'url' => route('panel.permissions')
            ],
            [
                'name' => 'Editar - '.$permission->label,
                'class' => 'text-dark',
                'url' => route('panel.permissions.edit',['permission'=>$permission->id])
            ]
        ];

        $this->permission = $permission;
        $this->name = $permission->name;
        $this->label = $permission->label;
        $this->group_name = $permission->group_name;
    }

    public function render()
    {
        return view('livewire.panel.permissions-edit');
    }

    public function store()
    {
        $validated = $this->validate(
            [ 
                'name' => [
                    'required',
                    Rule::unique('permissions')->ignore($this->permission), 
                ],
                'label' => 'required',
                'group_name' => 'required',
            ],
            [
                'name.required' => 'O código da permissão é obrigatório',
                'name.unique' => 'Já existe um registro com este código',
                'label.required' => 'O código da permissão é obrigatório',
                'group_name.required' => 'O código da permissão é obrigatório',
            ]
        );

        $permission_service = new PermissionService;
        $response = $permission_service->update($this->permission, $validated);
        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }else{
            return $this->redirectRoute('panel.permissions', navigate: true);
        }
    }
}
