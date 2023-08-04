<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;

class Admin extends Component
{
    #[Title('Dashboard')] 
    public function render()
    {
        return view('livewire.pages.admin');
    }
}
