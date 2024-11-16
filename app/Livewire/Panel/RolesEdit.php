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
    public $page_subtitle = 'Editar';
    public $permissions;
    public $role;

    #[Validate('required', message: 'A Tag da equipe é obrigatória')]
    public $name;

    #[Validate('required', message: 'O Título de identificação é obrigatório')]
    public $label;

    #[Validate('required', message: 'Selecione ao menos uma permissão')]
    public $permission_id = [];

    public function mount(Role $role)
    { 
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
        
        $validated = $this->validate();

        $role_service = new RoleService;
        $response = $role_service->update($this->role, $validated);
        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
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
