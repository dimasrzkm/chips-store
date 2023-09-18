<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $product;

    public $name;

    public $initial_price;

    public $percentage_profit;

    public $sale_price;

    public $stock = 0;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public function setPost(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->initial_price = $product->initial_price;
        $this->percentage_profit = $product->percentage_profit;
        $this->sale_price = $product->sale_price;
        $this->stock = $product->stock;
        $this->modeInput = 'ubah';
    }

    public function create()
    {
        try {
            Product::create($this->only(['name', 'initial_price', 'percentage_profit', 'sale_price', 'stock']));
            session()->flash('status', 'Berhasil menambah data produk');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->product->update($this->only(['name', 'initial_price', 'percentage_profit', 'sale_price', 'stock']));
            $this->resetField();
            session()->flash('status', 'Berhasil mengubah data produk');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->product->delete();
            $this->resetField();
            session()->flash('status', 'Berhasil menghapus data produk');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function calculatePrice()
    {
        $this->sale_price = ($this->initial_price) + ($this->initial_price / 100) * $this->percentage_profit;
    }

    protected function resetField()
    {
        return $this->reset('name', 'initial_price', 'percentage_profit', 'sale_price', 'stock', 'product', 'modeInput');
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'initial_price' => ['required', 'numeric'],
            'percentage_profit' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
        ];

    }
}
