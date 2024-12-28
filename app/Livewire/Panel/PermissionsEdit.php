<?php

namespace App\Livewire\Panel;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Permission;
use App\Services\PermissionService;

class PermissionsEdit extends Component
{

    use LivewireAlert;

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
        $data = [
            'name' => $this->name,
            'label' => $this->label,
            'group_name' => $this->group_name
        ];

        $permission_service = new PermissionService;
        $response = $permission_service->update($this->permission, $data);
        if(isset($response->original['error']) && $response->original['error']){
            $messages_error = $response->original['message'] ?? [];
            foreach ($messages_error as $key => $messages_array) {
                foreach ($messages_array as $message_item) {
                    $this->addError($key, $message_item);
                }
            }
            $this->alert('error', 'Verifique os erros sinalizados nos campos',['timer' => '6000']);
        }else{
            return $this->redirectRoute('panel.permissions', navigate: true);
        }
    }
}
