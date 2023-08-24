<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditUsers extends Component
{
    public UserForm $form;

    public function mount(User $user)
    {
        $this->form->setPost($user);
    }

    public function submit()
    {
        $this->validate();
        $this->form->update();

        return $this->redirectRoute('users.index', navigate: true);
    }

    #[Title('Ubah Data Pengguna')]
    public function render()
    {
        return view('livewire.users.edit-users');
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
        'form.email' => 'email',
        'form.username' => 'username',
        'form.password' => 'password',
        'form.address' => 'alamat',
        'form.telephone_number' => 'no telepon',
    ];
}
