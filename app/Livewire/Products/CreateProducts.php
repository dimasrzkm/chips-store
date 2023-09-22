<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Konsinyor;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateProducts extends Component
{
    public ProductForm $form;

    public function submit()
    {
        $this->validate();
        $this->form->create();

        return $this->redirectRoute('products.index', navigate: true);
    }

    #[Title('Tambah Data Produk')]
    public function render()
    {
        return view('livewire.products.edit-products');
    }

    public function updatedFormCategoryProduct($data)
    {
        if ($data == '1') {
            $this->form->categoryProduct = 1;
            $this->form->allKonsinyors = Konsinyor::all();
        } else {
            $this->form->categoryProduct = 0;
            $this->form->konsinyor_id = null;
        }
    }

    public function updatedFormInitialPrice($data)
    {
        $this->form->initial_price = $data;
        if ($this->form->percentage_profit != '' && $data != '') {
            $this->form->calculatePrice();
        } else {
            $this->form->sale_price = $data;
        }
    }

    public function updatedFormPercentageProfit($data)
    {
        $this->form->percentage_profit = $data;
        if ($this->form->initial_price != '' && $data != '') {
            $this->form->calculatePrice();
        } else {
            $this->form->sale_price = $this->form->initial_price;
        }
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
        'form.initial_price' => 'harga awal',
        'form.percentage_profit' => 'persentase keuntungan',
        'form.sale_price' => 'harga jual',
        'form.stock' => 'stok',
        'form.categoryProduct' => 'kategori produk',
    ];
}