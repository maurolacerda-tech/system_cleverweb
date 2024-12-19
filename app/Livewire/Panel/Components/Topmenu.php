<?php

namespace App\Livewire\Panel\Components;

use Livewire\Component;
use Livewire\Attributes\On; 

class Topmenu extends Component
{
    public $menutop_is_open = false;

    public function render()
    {
        return view('livewire.panel.components.topmenu');
    }

    #[On('openmenutop')] 
    public function menu_open()
    {
        $this->menutop_is_open = !$this->menutop_is_open;
        if(!$this->menutop_is_open){
            $this->js("window.document.getElementById('drawer-overlay-top').style.display = 'none'");
        }else{
            $this->js("window.document.getElementById('drawer-overlay-top').style.display = 'block'");
        }
    }
}
