<?php

namespace App\Livewire\RolesPermissions;

use App\Livewire\Forms\ApplyRolesForm;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowApplyRoles extends Component
{
    use WithPagination;

    public ApplyRolesForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function revokeRole(User $user)
    {
        $user->removeRole(implode(', ', $user->getRoleNames()->toArray()));
        session()->flash('status', 'Pengguna tidak memiliki peran lagi');
    }

    #[Title('Pemberian Peran')]
    public function render()
    {
        $users = User::orderBy('created_at', 'asc')->paginate($this->form->showPerPage, pageName: 'apply-role-page');
        if ($this->form->search !== '') {
            $users = User::where('name', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'apply-role-page');
        }

        return view('livewire.roles-permissions.show-apply-roles', ['users' => $users]);
    }
}
