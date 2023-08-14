<?php

namespace App\Livewire\Permissions;

use App\Livewire\Forms\PermissionsForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class ShowPermissions extends Component
{
    use WithPagination;

    public PermissionsForm $form;

    public function search()
    {
        $this->resetPage('permission-page');
    }

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getIdForDelete($permission)
    {
        $permissionDelete = Permission::findById($permission['id'], $permission['guard_name']);
        $this->form->setPost($permissionDelete);
    }

    public function deletePermission()
    {
        $this->form->destroyPermission();

        return $this->redirectRoute('permissions.index', navigate: true);
    }

    #[Title('Permissions')]
    public function render()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate($this->form->showPerPage, pageName: 'permission-page');

        if ($this->form->search !== '') {
            $permissions = Permission::where('name', 'like', '%'.$this->form->search.'%')
                ->latest()
                ->paginate($this->form->showPerPage, pageName: 'permission-page');
        }

        return view('livewire.permissions.show-permissions',
            ['permissions' => $permissions]
        );
    }
}
