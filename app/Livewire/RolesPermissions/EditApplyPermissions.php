<?php

namespace App\Livewire\RolesPermissions;

use App\Livewire\Forms\ApplyPermissionsForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class EditApplyPermissions extends Component
{
    public ApplyPermissionsForm $form;

    public function mount($role)
    {
        $this->form->setPost($role);
    }

    public function submit()
    {
        $this->validate();
        $this->form->synchronize();

        return $this->redirectRoute('assignable.index', navigate: true);
    }

    #[Title('Pemberian Izin')]
    public function render()
    {
        return view('livewire.roles-permissions.edit-apply-permissions', [
            'roles' => $this->form->role,
            'permissions' => Permission::all(),
        ]);
    }

    protected $validationAttributes = [
        'form.role_id' => 'Peran',
        'form.permissions' => 'Izin',
    ];
}
