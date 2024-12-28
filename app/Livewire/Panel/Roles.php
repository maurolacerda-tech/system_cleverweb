<?php

namespace App\Livewire\Panel;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate; 
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Permission;
use App\Services\RoleService;
use Illuminate\Support\Facades\Gate;

class Roles extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $page_title = 'Grupos de Trabalho';
    public $page_subtitle = [];
    public $search_label = '';
    public $permissions;
    public $last_id_update;

    public $name, $label, $permission_id = [];

    public function mount()
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
                'class' => 'text-dark',
                'url' => route('panel.roles')
            ]
        ];
        $this->permissions = Permission::orderBy('group_name','asc')->orderBy('label','asc')->get();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function select_all()
    {
        $permissions_array = Permission::select('id','name')->orderBy('name','asc')->get()->pluck('name','id')->all();
        $this->permission_id = array_keys($permissions_array) ?? [];
    }

    public function render()
    {
        if( Gate::denies("manager_system_show_roles") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $search_array = [
            'search_label' => $this->search_label
        ];
        $role_service = new RoleService;
        $response = $role_service->list($search_array);

        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }
        $roles = $response->original['data'];

        return view(
            'livewire.panel.roles', 
            compact('roles')
        );
    }

    public function store()
    {
        if( Gate::denies("manager_system_add_roles") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $data = [
            'name' => $this->name,
            'label' => $this->label,
            'permission_id' => $this->permission_id
        ];
        $role_service = new RoleService;
        $response = $role_service->store($data);
        if(isset($response->original['error']) && $response->original['error']){
            $messages_error = $response->original['message'] ?? [];
            foreach ($messages_error as $key => $messages_array) {
                foreach ($messages_array as $message_item) {
                    $this->addError($key, $message_item);
                }
            }
            $this->alert('error', 'Verifique os erros sinalizados nos campos',['timer' => '6000']);
        }else{
            $this->reset(['permission_id', 'name', 'label']);
            $this->js("document.getElementById('btn_close_modal_add').click();");
            $this->alert('success', 'Grupo de Trabalho adicionada com sucesso!',['timer' => '6000']);
            $this->last_id_update = $response->original['data']->id;
        }
    }

    public function delete_item($role_id)
    {
        $role_service = new RoleService;
        $response = $role_service->delete_item($role_id);
        if (isset($response->original['error']) && $response->original['error']) {
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }else{
            $this->alert('success', 'Excluído com sucesso!',['timer' => '6000']);
        }
    }
}
