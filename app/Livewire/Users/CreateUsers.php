<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateUsers extends Component
{
    public UserForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->store();

        return $this->redirectRoute('users.index', navigate: true);
    }

    #[Title('Tambah Pengguna')]
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

    public function updatedFormName($data)
    {
        $this->form->username = Str::slug($data, '_');
    }
}
