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

    public $page_title = 'Permissões';
    public $page_subtitle = [];

    public $search_label, $search_group, $last_id_update;

    public $group_name = 'system', $name = '', $label = '';

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
                'name' => 'Permissões',
                'class' => 'text-dark',
                'url' => route('panel.permissions')
            ]
        ];
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        if( Gate::denies("manager_system_permission") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

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
        return view('livewire.panel.permissions',compact('permissions','group_list'));
    }

    public function store()
    {
        if( Gate::denies("manager_system_permission") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $data = [
            'name' => $this->name,
            'label' => $this->label,
            'group_name' => $this->group_name
        ];
        $permission_service = new PermissionService;
        $response = $permission_service->store($data);
        if(isset($response->original['error']) && $response->original['error']){
            $messages_error = $response->original['message'] ?? [];
            foreach ($messages_error as $key => $messages_array) {
                foreach ($messages_array as $message_item) {
                    $this->addError($key, $message_item);
                }
            }
            $this->alert('error', 'Verifique os erros sinalizados nos campos',['timer' => '6000']);
        }else{
            $this->reset(['group_name', 'name', 'label']);
            $this->js("document.getElementById('btn_close_modal_add').click();");
            $this->alert('success', 'Permissão adicionada com sucesso!',['timer' => '6000']);
            $this->last_id_update = $response->original['data']->id;
        }
        
    }
}
