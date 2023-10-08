<?php

namespace App\Livewire\Permissions;

use App\Livewire\Forms\PermissionsForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreatePermissions extends Component
{
    public PermissionsForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->savePermission();

        return $this->redirectRoute('permissions.index', navigate: true);
    }

    #[Title('Permissions Create')]
    public function render()
    {
        return view('livewire.permissions.edit-permissions');
    }

    protected $validationAttributes = [
        'form.name' => 'name',
    ];
}
