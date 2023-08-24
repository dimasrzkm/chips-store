<?php

namespace App\Livewire\RolesPermissions;

use App\Livewire\Forms\ApplyRolesForm;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditApplyRoles extends Component
{
    public ApplyRolesForm $form;

    public function mount(User $user)
    {
        $this->form->setPost($user);
    }

    public function submit()
    {
        $this->validate();
        $this->form->synchronize();

        return $this->redirectRoute('assign.index', navigate: true);
    }

    #[Title('Pemberian Peran')]
    public function render()
    {
        return view('livewire.roles-permissions.edit-apply-roles', [
            'user' => $this->form->user,
            'roles' => Role::all(),
        ]);
    }

    protected $validationAttributes = [
        'form.user_id' => 'pengguna',
        'form.roles' => 'peran',
    ];
}
