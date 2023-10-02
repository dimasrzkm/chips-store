<?php

namespace App\Livewire\Forms;

use App\Models\Stock;
use Livewire\Attributes\Url;
use Livewire\Form;

class StocksForm extends Form
{
    public ?Stock $stock;

    public $modeInput = 'tambah';

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $supplier_id;

    public $unit_id;

    public $name;

    public $purchase_date;

    public $price;

    // public $total;

    public $initial_stock;

    public $remaining_stock;

    public function setPost(Stock $stock)
    {
        $this->stock = $stock;
        $this->supplier_id = $stock->supplier_id;
        $this->unit_id = $stock->unit_id;
        $this->name = $stock->name;
        $this->purchase_date = $stock->purchase_date->format('Y-m-d');
        $this->price = $stock->price;

        // $this->total = $stock->total;

        $this->initial_stock = $stock->initial_stock;
        $this->remaining_stock = $stock->remaining_stock;

        $this->modeInput = 'ubah';
    }

    public function create()
    {
        try {
            $this->remaining_stock = $this->initial_stock;
            Stock::create($this->only(['supplier_id', 'unit_id', 'name', 'purchase_date', 'price', 'initial_stock', 'remaining_stock']));
            session()->flash('status', 'Bahan baku berhasil di tambah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->stock->update($this->only(['supplier_id', 'unit_id', 'name', 'purchase_date', 'price', 'initial_stock', 'remaining_stock']));
            $this->resetField();
            session()->flash('status', 'Bahan baku berhasil di ubah');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->stock->delete();
            $this->resetField();
            session()->flash('status', 'Bahan baku berhasil di hapus');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'supplier_id' => ['required'],
            'unit_id' => ['required'],
            'name' => ['required'],
            'purchase_date' => ['required', 'date'],
            'price' => ['required', 'numeric'],
            'initial_stock' => ['required', 'numeric'],
        ];
    }

    protected function resetField()
    {
        return $this->reset('supplier_id', 'unit_id', 'name', 'purchase_date', 'price', 'initial_stock', 'stock', 'modeInput');
    }
}
