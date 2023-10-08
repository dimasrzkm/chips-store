<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Url;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    public ?Role $role;

    public $name;

    public $guard_name = 'web';

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public function setPost(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->modeInput = 'ubah';
    }

    public function saveRole()
    {
        try {
            Role::create($this->only(['name', 'guard_name']));
            session()->flash('status', 'Peran berhasil di tambah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function updateRole()
    {
        try {
            $this->role->update($this->only(['name', 'guard_name']));
            session()->flash('status', 'Peran berhasil di ubah');
            $this->reset('role', 'name', 'guard_name', 'modeInput');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroyRole()
    {
        try {
            $this->role->delete();
            session()->flash('status', 'Peran berhasil di hapus');
            $this->reset('role', 'name', 'guard_name');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z\s]*$/'],
        ];
    }
}
