<?php

namespace App\Livewire\Panel;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\WithFileUploads;

class UsersEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $page_title = 'Usuários';
    public $page_subtitle = [];
    public $roles;
    public $user;
    public $image_show;

    public $image, $name, $email, $password, $status, $role_id = [];

    public function mount(User $user)
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
                'class' => 'text-muted',
                'url' => route('panel.users')
            ],
            [
                'name' => "Editar - {$user->name}",
                'class' => 'text-dark',
                'url' => route('panel.users.edit',['user'=>$user->id])
            ]
        ];

        $this->roles = Role::orderBy('label','asc')->get();
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->image_show = $user->image;

        $this->role_id = array_keys($user->roles->pluck('name','id')->all()) ?? [];
    }

    public function render()
    {
        $this_user_id = Auth::user()->id;
        if($this_user_id != $this->user->id){
            if( Gate::denies("manager_system_edit_users") ){
                abort(403, 'Você não tem permissão para gerenciar esta página');
            }
        }

        return view('livewire.panel.users-edit');
    }

    public function store()
    {
        $this_user_id = Auth::user()->id;
        if( Gate::denies("manager_system_edit_users") && $this_user_id != $this->user->id ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');
        
        $user_service = new UserService;
        $response = $user_service->update(
            $this->user, 
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
            return $this->redirectRoute('panel.users', navigate: true);
        }
    }

    public function select_all()
    {
        $roles_array = Role::select('id','label')->orderBy('label','asc')->get()->pluck('label','id')->all();
        $this->role_id = array_keys($roles_array) ?? [];
    }
}
