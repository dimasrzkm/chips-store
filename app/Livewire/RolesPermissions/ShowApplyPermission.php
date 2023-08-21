<?php

namespace App\Livewire\RolesPermissions;

use App\Livewire\Forms\ApplyPermissionsForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShowApplyPermission extends Component
{
    use WithPagination;

    public ApplyPermissionsForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    #[Title('Pemberian Izin')]
    public function render()
    {
        $roles = Role::orderBy('created_at', 'asc')->paginate($this->form->showPerPage, pageName: 'apply-permissions-page');

        if ($this->form->search !== '') {
            $roles = Role::where('name', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'apply-permissions-page');
        }

        return view('livewire.roles-permissions.show-apply-permission', [
            'roles' => $roles,
            'permissions' => Permission::all(),
        ]);
    }
}
