<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\PasswordForm;
use Livewire\Component;

class UpdatePassword extends Component
{
    public PasswordForm $form;

    public function boot()
    {
        $this->form->user = auth()->user();
    }

    public function updatePassword()
    {
        $this->validate();
        $this->form->storePassword();

        return $this->redirectRoute('profile', auth()->user()->username, navigate: true);
    }

    public function render()
    {
        return view('livewire.profile.update-password');
    }

    protected $validationAttributes = [
        'form.oldPassword' => 'current password',
        'form.newPassword' => 'new password',
        'form.newConfirmPassword' => 'password confirmation',
    ];
}
