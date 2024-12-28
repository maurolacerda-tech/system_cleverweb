<?php

namespace App\Livewire\Panel;

use App\Models\Permission;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RolesEdit extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $page_title = 'Grupos de Trabalho';
    public $page_subtitle = [];
    public $permissions;
    public $role;

    public $name, $label, $permission_id = [];

    public function mount(Role $role)
    { 
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
                'name' => 'Grupos de Trabalho',
                'class' => 'text-muted',
                'url' => route('panel.roles')
            ],
            [
                'name' => 'Editar - '.$role->label,
                'class' => 'text-dark',
                'url' => route('panel.roles.edit',['role'=>$role->id])
            ]
        ];

        $this->permissions = Permission::orderBy('group_name','asc')->orderBy('label','asc')->get();
        $this->role = $role;

        $this->name = $role->name;
        $this->label = $role->label;

        $this->permission_id = array_keys($role->permissions->pluck('name','id')->all()) ?? [];
    }

    public function render()
    {
        if( Gate::denies("manager_system_edit_roles") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        return view('livewire.panel.roles-edit');
    }

    public function store()
    {
        if( Gate::denies("manager_system_edit_roles") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $role_service = new RoleService;
        $response = $role_service->update(
            $this->role,
            [
                'name' => $this->name,
                'label' => $this->label,
                'permission_id' => $this->permission_id
            ]
        );
        if(isset($response->original['error']) && $response->original['error']){
            $messages_error = $response->original['message'] ?? [];
            foreach ($messages_error as $key => $messages_array) {
                foreach ($messages_array as $message_item) {
                    $this->addError($key, $message_item);
                }
            }
            $this->alert('error', 'Verifique os erros sinalizados nos campos',['timer' => '6000']);
        }else{
            return $this->redirectRoute('panel.roles', navigate: true);
        }
    }

    public function select_all()
    {
        $permissions_array = Permission::select('id','name')->orderBy('name','asc')->get()->pluck('name','id')->all();
        $this->permission_id = array_keys($permissions_array) ?? [];
    }
}
