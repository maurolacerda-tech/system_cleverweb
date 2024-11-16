<?php

namespace App\Livewire\Components;

use Livewire\Component;

class LoaderManager extends Component
{

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="loader">
                <ul>
                    <li class="center"></li>
                    <li class="item item-1"></li>
                    <li class="item item-2"></li>
                    <li class="item item-3"></li>
                    <li class="item item-4"></li>
                    <li class="item item-5"></li>
                    <li class="item item-6"></li>
                    <li class="item item-7"></li>
                    <li class="item item-8"></li>
                </ul>
            </div>
        </div>
        HTML;
    }
    
    public function render()
    {
        return view('livewire.components.loader-manager');
    }
}
