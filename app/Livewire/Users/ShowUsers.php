<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUsers extends Component
{
    use WithPagination;

    public UserForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete($data)
    {
        $this->form->setPost(User::find($data['id']));
    }

    public function deleteUser()
    {
        $this->form->destroy();

        return $this->redirectRoute('users.index', navigate: true);
    }

    #[Title('Data Pengguna')]
    public function render()
    {
        $users = User::orderBy('name', 'asc')->paginate($this->form->showPerPage, pageName: 'user-page');
        if ($this->form->search !== '') {
            $users = User::where('name', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'user-page');
        }

        return view('livewire.users.show-users', [
            'users' => $users,
        ]);
    }
}
