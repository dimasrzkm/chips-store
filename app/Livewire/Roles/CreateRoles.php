<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateRoles extends Component
{
    public RoleForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->saveRole();

        return $this->redirectRoute('roles.index', navigate: true);
    }

    #[Title('Create Roles')]
    public function render()
    {
        return view('livewire.roles.edit-roles');
    }

    protected $validationAttributes = [
        'form.name' => 'name',
    ];
}
