<?php

namespace App\Livewire\Panel;

use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Livewire\Attributes\Validate; 

class Permissions extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $search_label, $search_group, $last_id_update;

    #[Validate('required', message: 'O Grupo da permissão é obrigatório')] 
    public $group_name = 'system';

    #[Validate('required', message: 'O código da permissão é obrigatório')] 
    #[Validate('unique:permissions', message: 'Já existe um registro com este código')]
    public $name = '';

    #[Validate('required', message: 'O Título de identificação é obrigatório')] 
    public $label = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        if( Gate::denies("manager_system_permission") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $page_title = 'Permissões';

        $group_list = Permission::GROUP_LIST;
        $search_array = [
            'search_label' => $this->search_label,
            'search_group' => $this->search_group
        ];
        $permission_service = new PermissionService;
        $response = $permission_service->list($search_array);

        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }
        $permissions = $response->original['data'];
        return view('livewire.panel.permissions',compact('permissions','page_title','group_list'));
    }

    public function store()
    {
        if( Gate::denies("manager_system_permission") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $validated = $this->validate();
        $data = [
            'name' => $this->name,
            'label' => $this->label,
            'group_name' => $this->group_name
        ];
        $permission_service = new PermissionService;
        $response = $permission_service->store($data);
        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }else{
            $this->reset(['group_name', 'name', 'label']);
            $this->js("document.getElementById('btn_close_modal_add').click();");
            $this->alert('success', 'Permissão adicionada com sucesso!',['timer' => '6000']);
            $this->last_id_update = $response->original['data']->id;
        }
        
    }
}
