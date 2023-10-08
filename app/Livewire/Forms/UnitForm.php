<?php

namespace App\Livewire\Forms;

use App\Models\Unit;
use Livewire\Attributes\Url;
use Livewire\Form;

class UnitForm extends Form
{
    public ?Unit $unit;

    public $name;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public function setPost(Unit $unit)
    {
        $this->unit = $unit;
        $this->name = $unit->name;
        $this->modeInput = 'ubah';
    }

    public function create()
    {
        try {
            Unit::create($this->only(['name']));
            session()->flash('status', 'Satuan berhasil di tambah');
        } catch (\Exception $e) {
            session()->flash('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->unit->update($this->only(['name']));
            session()->flash('status', 'Satuan berhasil di ubah');
            $this->reset('unit', 'name');
        } catch (\Exception $e) {
            session()->flash('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->unit->delete();
            session()->flash('status', 'Satuan berhasil di hapus');
            $this->reset('unit', 'name');
        } catch (\Exception $e) {
            session()->flash('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z\s]*$/'],
        ];
    }
}
