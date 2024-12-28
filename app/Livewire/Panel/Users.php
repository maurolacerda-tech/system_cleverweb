<?php

namespace App\Livewire\Panel;

use App\Models\Role;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Livewire\Attributes\Validate; 
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

use Livewire\Component;

class Users extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $page_title = 'Usuários';
    public $page_subtitle = [];
    public $search_name = '';
    public $search_role = '';
    public $last_id_update;
    public $roles;
    public $image_show;

    public $image, $name, $email, $password, $status, $role_id = [];


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
                'name' => 'Usuários',
                'class' => 'text-dark',
                'url' => route('panel.users')
            ]
        ];

        $this->roles = Role::orderBy('label','asc')->get();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        if( Gate::denies("manager_system_show_users") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $search_array = [
            'search_name' => $this->search_name,
            'search_role' => $this->search_role
        ];
        $user_service = new UserService;
        $response = $user_service->list($search_array);

        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }
        $users = $response->original['data'];

        return view('livewire.panel.users', compact('users'));
    }

    public function select_all()
    {
        $roles_array = Role::select('id','label')->orderBy('label','asc')->get()->pluck('label','id')->all();
        $this->role_id = array_keys($roles_array) ?? [];
    }

    public function store()
    {
        if( Gate::denies("manager_system_add_users") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        //$this->addError(['name'], ['fake mesage']);

        $user_service = new UserService;
        $response = $user_service->store(
            [
                'image' => $this->image,
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'status' => $this->status,
                'role_id' => $this->role_id,
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
            $this->reset(['image', 'name', 'email', 'password', 'status','role_id']);
            $this->js("document.getElementById('btn_close_modal_add').click();");
            $this->alert('success', 'Adicionado com sucesso!',['timer' => '6000']);
            $this->last_id_update = $response->original['data']->id;
        }
    }

    public function change_status(int $user_id)
    {
        $user_service = new UserService;
        $response = $user_service->change_status($user_id);
        if (isset($response->original['error']) && $response->original['error']) {
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }else{
            $this->alert('success', 'Atualizado com sucesso!',['timer' => '6000']);
        }
    }

    public function delete_item($user_id)
    {
        $user_service = new UserService;
        $response = $user_service->delete_item($user_id);
        if (isset($response->original['error']) && $response->original['error']) {
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }else{
            $this->alert('success', 'Excluído com sucesso!',['timer' => '6000']);
        }
    }
}
