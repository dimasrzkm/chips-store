<?php

namespace App\Livewire\RolesPermissions;

use App\Livewire\Forms\ApplyRolesForm;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ApplyRoles extends Component
{
    public ApplyRolesForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->apply();

        return $this->redirectRoute('assign.index', navigate: true);
    }

    #[Title('Pemberian Peran')]
    public function render()
    {
        return view('livewire.roles-permissions.edit-apply-roles', [
            'users' => User::all(),
            'roles' => Role::all(),
        ]);
    }

    protected $validationAttributes = [
        'form.user_id' => 'pengguna',
        'form.roles' => 'peran',
    ];
}
