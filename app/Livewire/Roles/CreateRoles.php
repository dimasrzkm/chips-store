<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateRoles extends Component
{
    public RoleForm $form;

    public function createRole()
    {
        $this->validate();
        $this->form->saveRole();

        return $this->redirectRoute('roles.index', navigate: true);
    }

    #[Title('Create Roles')]
    public function render()
    {
        return view('livewire.roles.create-roles', [
            'guards' => ['web', 'api'],
        ]);
    }

    protected $validationAttributes = [
        'form.name' => 'name',
        'form.guard_name' => 'guard name',
    ];
}
