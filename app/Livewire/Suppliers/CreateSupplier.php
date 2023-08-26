<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateSupplier extends Component
{
    public SupplierForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->store();

        return $this->redirectRoute('suppliers.index', navigate: true);
    }

    #[Title('Tambah Data Supplier')]
    public function render()
    {
        return view('livewire.suppliers.edit-supplier');
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
        'form.address' => 'alamat',
        'form.telephone_number' => 'no telpon',
    ];
}
