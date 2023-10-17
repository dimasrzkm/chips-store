<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Url;
use Livewire\Form;
use Spatie\Permission\Models\Permission;

class PermissionsForm extends Form
{
    public ?Permission $permission;

    public $name;

    public $guardName = 'web';

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public function setPost(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->guardName = $permission->guard_name;
        $this->modeInput = 'ubah';
    }

    public function savePermission()
    {
        try {
            Permission::create(['name' => $this->name, 'guard_name' => $this->guardName]);
            session()->flash('status', 'Izin berhasil di tambah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function updatePermission()
    {
        try {
            $this->permission->update($this->only(['name', 'guardName']));
            session()->flash('status', 'Izin berhasil di ubah');
            $this->reset('permission', 'name', 'guardName', 'modeInput');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroyPermission()
    {
        $this->permission->delete();
        session()->flash('status', 'Izin berhasil di hapus');
        $this->reset('permission', 'name', 'guardName');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z\s]*$/'],
        ];
    }
}
