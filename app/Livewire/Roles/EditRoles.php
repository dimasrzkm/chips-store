<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditRoles extends Component
{
    public RoleForm $form;

    public function mount(Role $role = null)
    {
        $this->form->setPost($role);
    }

    public function editRole()
    {
        $this->validate();
        $this->form->updateRole();

        return $this->redirectRoute('roles.index', navigate: true);
    }

    #[Title('Edit Roles')]
    public function render()
    {
        return view('livewire.roles.edit-roles', [
            'guards' => ['web', 'api'],
        ]);
    }

    protected $validationAttributes = [
        'form.name' => 'name',
    ];
}
