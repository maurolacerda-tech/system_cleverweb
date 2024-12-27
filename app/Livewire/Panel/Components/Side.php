<?php

namespace App\Livewire\Panel\Components;

use App\Services\AuthService;
use Livewire\Component;
use Livewire\Attributes\On; 

class Side extends Component
{
    public $menu_is_open = false;
    public $menumobile_is_open = false;

    public function mount()
    {
        $this->js('window.body_site = document.querySelector("body");');
        $this->js('window.kt_aside = document.getElementById("kt_aside");');
    }

    public function render()
    {
        return view('livewire.panel.components.side');
    }

    #[On('openmenu')] 
    public function menu_open()
    {
        $this->menu_is_open = !$this->menu_is_open;
        
        if($this->menu_is_open){
            $this->js('body_site.setAttribute("data-kt-aside-minimize", "on");');
        }else{
            $this->js('body_site.removeAttribute("data-kt-aside-minimize");');
        }
    }

    #[On('openmenumobile')] 
    public function menu_mobile_open()
    {
        $this->menumobile_is_open = !$this->menumobile_is_open;
        
        if($this->menumobile_is_open){
            $this->js('setTimeout(() => { body_site.setAttribute("data-kt-drawer-aside", "on"); body_site.setAttribute("data-kt-drawer", "on"); kt_aside.classList.add("drawer"); kt_aside.classList.add("drawer-on");document.getElementById("drawer-overlay").style="display:block"; }, 300);');
        }else{
            $this->js('setTimeout(() => { body_site.removeAttribute("data-kt-drawer-aside"); body_site.removeAttribute("data-kt-drawer"); kt_aside.classList.remove("drawer"); kt_aside.classList.remove("drawer-on");document.getElementById("drawer-overlay").style="display:none"; }, 300);');
        }
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
