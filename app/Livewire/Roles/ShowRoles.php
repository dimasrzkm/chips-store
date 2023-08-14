<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ShowRoles extends Component
{
    use WithPagination;

    public RoleForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete($role)
    {
        $this->form->setPost(Role::findById($role['id'], $role['guard_name']));
    }

    public function deleteRole()
    {
        $this->form->destroyRole();

        return $this->redirectRoute('roles.index', navigate: true);
    }

    #[Title('Roles')]
    public function render()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate($this->form->showPerPage, pageName: 'role-page');

        if ($this->form->search !== '') {
            $roles = Role::where('name', 'like', '%'.$this->form->search.'%')
                ->latest()
                ->paginate($this->form->showPerPage, pageName: 'role-page');
        }

        return view('livewire.roles.show-roles', [
            'roles' => $roles,
        ]);
    }
}
