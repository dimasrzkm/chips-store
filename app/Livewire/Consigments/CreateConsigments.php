<?php

namespace App\Livewire\Consigments;

use App\Livewire\Forms\ConsigmentForm;
use App\Models\Consigment;
use App\Models\Konsinyor;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateConsigments extends Component
{
    public ConsigmentForm $form;

    public function mount()
    {
        $this->form->number_transaction = (Consigment::latest()->first()) ? Consigment::latest()->first()->number_transaction + 1 : 1;
        $this->form->transaction_code = 'TPK-'.str_pad($this->form->number_transaction, 4, '0', STR_PAD_LEFT);
        $this->form->user_id = auth()->user()->id;

        $this->form->allKonsinyors = Konsinyor::all();

        $this->form->allProducts = Product::with('konsinyor')->whereHas('konsinyor')->get();
    }

    #[Title('Penitipan Barang')]
    public function render()
    {
        return view('livewire.consigments.create-consigments');
    }

    public function submit()
    {
        $this->validate();
        $this->form->create();

        return $this->redirectRoute('consigments.index', navigate: true);
    }

    protected $validationAttributes = [
        'form.consigment_date' => 'tanggal penitipan',
        'form.konsinyor_id' => 'pentip barang',
        'form.selectedProducts' => 'produk titipan',
    ];

    public function addProduct()
    {
        $this->form->selectedProducts[] = [];
    }

    public function removeProduct($index)
    {
        unset($this->form->selectedProducts[$index]);
        $this->form->selectedProducts = array_values($this->form->selectedProducts);
    }

    public function updatedFormKonsinyorId($data)
    {
        $this->form->allProducts = Product::with('konsinyor')
            ->whereHas('konsinyor', function (Builder $query) use ($data) {
                return $query->where('id', $data);
            })
            ->get();
    }
}
