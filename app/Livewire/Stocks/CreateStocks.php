<?php

namespace App\Livewire\Stocks;

use App\Livewire\Forms\StocksForm;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateStocks extends Component
{
    public StocksForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->create();

        return $this->redirectRoute('stocks.index', navigate: true);
    }

    #[Title('Tambah Bahan Baku')]
    public function render()
    {
        return view('livewire.stocks.edit-stocks', [
            'suppliers' => Supplier::all(),
        ]);
    }

    protected $validationAttributes = [
        'form.supplier_id' => 'supplier',
        'form.name' => 'nama',
        'form.purchase_date' => 'tanggal_pengadaan',
        'form.price' => 'harga',
        'form.total' => 'jumlah',
    ];
}
