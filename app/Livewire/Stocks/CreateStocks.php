<?php

namespace App\Livewire\Stocks;

use App\Models\Unit;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use App\Livewire\Forms\StocksForm;
use Illuminate\Support\Facades\DB;

class CreateStocks extends Component
{
    public StocksForm $form;

    public function mount()
    {
        $this->form->allStocks = DB::table('stocks')->distinct()->get(['name']);
    }

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
            'units' => Unit::all(),
        ]);
    }

    protected $validationAttributes = [
        'form.supplier_id' => 'supplier',
        'form.unit_id' => 'satuan',
        'form.name' => 'nama',
        'form.purchase_date' => 'tanggal_pengadaan',
        'form.price' => 'harga',
        'form.initial_stock' => 'jumlah',
        'form.total_price' => 'total',
    ];

    public function addNewStock()
    {
        $this->form->cekStockAlreadyExists = true;
    }

    public function updatedFormPrice()
    {
        if ($this->form->price != '') {
            $this->form->price = str_replace(".", "", $this->form->price);
            $this->form->price = number_format($this->form->price, 0, ',', '.');

            if ($this->form->initial_stock != '') {
                $this->form->total_price = str_replace(".", "", $this->form->price) * $this->form->initial_stock;
                $this->form->total_price = number_format($this->form->total_price, 0, ',', '.');
            } else {
                $this->form->total_price = 0;
            }
        } 
    }

    public function updatedFormInitialStock()
    {
        if ($this->form->initial_stock != '' && $this->form->price != '') {
            $this->form->total_price = str_replace(".", "", $this->form->price) * $this->form->initial_stock;
            $this->form->total_price = number_format($this->form->total_price, 0, ',', '.');
        } else {
            $this->form->total_price = 0;
        }
    }
}
