<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Attributes\Url;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public $name;

    public $address;

    public $telephone_number;

    public function setPost(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->name = $supplier->name;
        $this->address = $supplier->address;
        $this->telephone_number = $supplier->telephone_number;
        $this->modeInput = 'ubah';
    }

    public function store()
    {
        try {
            Supplier::create($this->only(['name', 'address', 'telephone_number']));
            session()->flash('status', 'Berhasil menambah data supplier');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->supplier->update($this->only(['name', 'address', 'telephone_number']));
            session()->flash('status', 'Berhasil mengubah data supplier');
            $this->reset('name', 'supplier', 'telephone_number');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->supplier->delete();
            $this->reset('name', 'supplier', 'telephone_number');
            session()->flash('status', 'Berhasil menghapus data supplier');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'address' => ['required', 'regex:/^[a-zA-Z0-9\s]*$/'],
            'telephone_number' => ['required', 'numeric', 'min_digits:12', 'max_digits:14'],
        ];
    }
}
