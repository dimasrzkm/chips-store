<?php

namespace App\Livewire\Forms;

use App\Models\Konsinyor;
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

    public $konsinyor_id;

    public $unit_id;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $modeInput = 'tambah';

    public $categoryProduct;

    public $allKonsinyors;

    public function setPost(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->initial_price = $product->initial_price;
        $this->percentage_profit = $product->percentage_profit;
        $this->sale_price = $product->sale_price;
        $this->stock = $product->stock;
        $this->unit_id = $product->unit_id;
        $this->modeInput = 'ubah';

        $this->categoryProduct = 0;
        if (! is_null($this->product->konsinyor)) {
            $this->categoryProduct = 1;
            $this->allKonsinyors = Konsinyor::all();
            $this->konsinyor_id = $this->product->konsinyor->id;
        }
    }

    public function create()
    {
        try {
            Product::create($this->only($this->attributes()));
            session()->flash('status', 'Berhasil menambah data produk');
        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->product->update($this->only($this->attributes()));
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

    public function attributes()
    {
        return ['name', 'initial_price', 'percentage_profit', 'sale_price', 'stock', 'konsinyor_id', 'unit_id'];
    }

    protected function resetField()
    {
        return $this->reset('name', 'initial_price', 'percentage_profit', 'sale_price', 'stock', 'product', 'modeInput');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z0-9\s]*$/'],
            'initial_price' => ['required', 'numeric'],
            'percentage_profit' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'categoryProduct' => ['required'],
            'unit_id' => ['required'],
        ];

    }
}
