<?php

namespace App\Livewire\Permissions;

use App\Livewire\Forms\PermissionsForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class EditPermissions extends Component
{
    public PermissionsForm $form;

    public function mount(Permission $permission = null)
    {
        $this->form->setPost($permission);
    }

    public function editPermission()
    {
        $this->validate();
        $this->form->updatePermission();

        return $this->redirectRoute('permissions.index', navigate: true);
    }

    #[Title('Permissions Edit')]
    public function render()
    {
        return view('livewire.permissions.edit-permissions', [
            'guards' => collect(['web', 'api']),
        ]);
    }

    protected $validationAttributes = [
        'form.name' => 'name',
    ];
}
