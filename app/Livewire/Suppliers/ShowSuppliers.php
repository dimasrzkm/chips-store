<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowSuppliers extends Component
{
    use WithPagination;

    public SupplierForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete($data)
    {
        $this->form->setPost(Supplier::find($data['id']));
    }

    public function deleteSupplier()
    {
        $this->form->destroy();
    }

    #[Title('Data Supplier')]
    public function render()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->paginate($this->form->showPerPage, pageName: 'supplier-page');
        if ($this->form->search !== '') {
            $suppliers = Supplier::where('name', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'supplier-page');
        }

        return view('livewire.suppliers.show-suppliers', [
            'suppliers' => $suppliers,
        ]);
    }
}
