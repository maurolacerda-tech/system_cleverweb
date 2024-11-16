<?php

namespace App\Livewire\Panel;

use Livewire\Component;
use App\Models\User;
use App\Services\AuthService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate; 
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth as AuthUser;

class Auth extends Component
{
    use LivewireAlert;

    public $is_error = 'no';
    
    #[Validate('required', message: 'O e-mail é obrigatório')]
    #[Validate('email', message: 'Necessário informar um e-mail válido')]
    public $email = '';

    #[Validate('required', message: 'A senha é obrigatória')] 
    public $password = '';

    #[Validate('required', message: 'Confirme que você não é um robô')]
    public $captcha = null;

    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.panel.auth');
    }

    public function store()
    {
        $validated = $this->validate();
        
        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'captcha' => $this->captcha
        ];
        $auth_service = new AuthService;
        $response = $auth_service->default_login($data);

        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
            return;
        }

        $this->redirect('/panel/dashboard');
        
    }
}
