<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditSupplier extends Component
{
    public SupplierForm $form;

    public function mount(Supplier $supplier)
    {
        $this->form->setPost($supplier);
    }

    public function submit()
    {
        $this->validate();
        $this->form->update();

        return $this->redirectRoute('suppliers.index', navigate: true);
    }

    #[Title('Ubah Data Supplier')]
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
