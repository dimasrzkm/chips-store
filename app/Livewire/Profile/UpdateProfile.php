<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\ProfileForm;
use App\Models\User;
use Livewire\Component;

class UpdateProfile extends Component
{
    public ProfileForm $form;

    public function mount(User $user)
    {
        $this->form->setPost($user);
    }

    public function updateProfile()
    {
        $this->validate();
        $this->form->storeProfile();

        return $this->redirectRoute('profile', $this->form->username, navigate: true);
    }

    public function render()
    {
        return view('livewire.profile.update-profile');
    }

    protected $validationAttributes = [
        'form.name' => 'name',
        'form.email' => 'email address',
        'form.username' => 'username',
        'form.address' => 'address',
        'form.telephone_number' => 'telephone_number',
    ];
}
