<?php

namespace App\Livewire\Panel\Components;

use App\Services\AuthService;
use Livewire\Component;

class Topbar extends Component
{
    public function render()
    {
        return view('livewire.panel.components.topbar');
    }

    public function logout()
    {
        $auth_service = new AuthService;
        $response = $auth_service->default_logout();
        if(isset($response->original['error']) && $response->original['error']){
            $this->alert('error', $response->original['message'],['timer' => '6000']);
        }else{
            return $this->redirectRoute('panel.auth', navigate: true);
        }
    }
}
