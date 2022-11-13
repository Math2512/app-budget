<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Debits extends Component
{

    public $showDiv = false;

    public function render()
    {
        return view('livewire.debits');
    }

    public function openDiv()
    {
        $this->showDiv =! $this->showDiv;
    }

}
