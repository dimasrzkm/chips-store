<?php

namespace App\Livewire\Stocks;

use App\Livewire\Forms\StocksForm;
use App\Models\Stock;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditStocks extends Component
{
    public StocksForm $form;

    public function mount(Stock $stock)
    {
        $this->form->setPost($stock);
    }

    public function submit()
    {
        $this->validate();
        $this->form->update();

        return $this->redirectRoute('stocks.index', navigate: true);
    }

    #[Title('Ubah Data Bahan Produk')]
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
