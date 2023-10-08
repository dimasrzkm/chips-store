<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Url;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class ApplyPermissionsForm extends Form
{
    public ?Role $role;

    public $modeInput = 'tambah';

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $role_id;

    public $permissions = [];

    public function setPost($data)
    {
        $this->role = Role::findByName($data);
        $this->role_id = $this->role->id;
        $this->permissions = $this->role->permissions->pluck('name')->toArray();
        $this->modeInput = 'ubah';
    }

    public function apply()
    {
        try {
            $role = Role::findById((int) $this->role_id);
            foreach ($this->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
            $this->reset('role_id', 'permissions');
            session()->flash('status', 'Berhasil mengizinkan');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function synchronize()
    {
        try {
            $role = Role::findById($this->role_id);
            $role->syncPermissions($this->permissions);
            $this->reset('role_id', 'permissions', 'modeInput');
            session()->flash('status', 'Berhasil mengupdate perizinan');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'role_id' => ['required'],
            'permissions' => ['required'],
        ];
    }
}
