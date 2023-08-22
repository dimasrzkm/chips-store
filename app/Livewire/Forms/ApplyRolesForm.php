<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Form;

class ApplyRolesForm extends Form
{
    public ?User $user;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $modeInput = 'tambah';

    public $showPerPage = 5;

    public $user_id;

    public $roles;

    public function setPost(User $data)
    {
        $this->user = $data;
        $this->user_id = $this->user->id;
        $this->roles = $this->user->getRoleNames()->toArray();
        $this->modeInput = 'ubah';
    }

    public function apply()
    {
        try {
            $user = User::find($this->user_id);
            foreach ($this->roles as $role) {
                $user->assignRole($role);
            }
            $this->reset('user_id', 'roles');
            session()->flash('status', 'berhasil memberikan user peran');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function synchronize()
    {
        try {
            $this->user->syncRoles($this->roles);
            $this->reset('user_id', 'roles');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules() {
        return [
            'user_id' => ['required'],
            'roles' => ['required']
        ];
    }
}
