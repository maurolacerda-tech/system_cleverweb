<?php

namespace App\Livewire\Panel\Components;

use Livewire\Component;
use Livewire\Attributes\On; 

class Side extends Component
{
    public $menu_is_open = false;

    public function render()
    {
        return view('livewire.panel.components.side');
    }

    #[On('openmenu')] 
    public function menu_open()
    {
        $this->menu_is_open = !$this->menu_is_open;
        if(!$this->menu_is_open){
            $this->js("window.document.getElementById('drawer-overlay').style.display = 'none'");
        }else{
            $this->js("window.document.getElementById('drawer-overlay').style.display = 'block'");
        }
    }
}
