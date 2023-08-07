<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Title;
use Livewire\Component;

class ProfileInformation extends Component
{
    #[Title('Informasi Profile')]
    public function render()
    {
        return view('livewire.profile.profile-information');
    }
}
