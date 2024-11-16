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
    public $page_subtitle = 'Editar';
    public $roles;
    public $user;
    public $image_show;

    #[Validate('nullable', message: 'Adicione uma imagem')]
    #[Validate('mimes:jpeg,png,jpg,gif,svg,webp', message: 'Formato de arquivo não permitido')]
    #[Validate('max:4096', message: 'Tamanho máximo para a imagem é de 4MB')]
    public $image;

    #[Validate('required', message: 'O nome é obrigatório')]
    public $name;

    #[Validate('required', message: 'Faltou preencher o e-mail')]
    #[Validate('email', message: 'Não é um e-mail válido')]
    public $email;

    #[Validate('nullable')]
    public $password;

    #[Validate('nullable', message: 'Status obrigatório')]
    public $status;

    #[Validate('required', message: 'Selecione ao menos uma equipe')]
    public $role_id = [];

    public function mount(User $user)
    { 
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
        if( Gate::denies("manager_system_edit_users") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');
        
        $validated = $this->validate();
        $user_service = new UserService;
        $response = $user_service->update($this->user, $validated);
        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
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
