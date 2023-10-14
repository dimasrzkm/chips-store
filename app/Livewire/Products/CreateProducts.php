<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Konsinyor;
use App\Models\Unit;
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
        return view('livewire.products.edit-products', ['units' => Unit::all()]);
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
        $this->form->initial_price = str_replace('.', '', $this->form->initial_price);
        $this->form->sale_price = str_replace('.', '', $this->form->sale_price);

        $this->changeFormatAndCalculatePrice('percentage_profit', $data);
    }

    public function updatedFormPercentageProfit($data)
    {
        $this->form->initial_price = str_replace('.', '', $this->form->initial_price);
        $this->form->sale_price = str_replace('.', '', $this->form->sale_price);

        $this->changeFormatAndCalculatePrice('initial_price', $data);
    }

    public function changeFormatAndCalculatePrice($data1, $data2)
    {
        if ($this->form->$data1 != '' && $data2 != '') {
            $this->form->calculatePrice();
            $this->form->sale_price = number_format($this->form->sale_price, 0, ',', '.');
        } else {
            $this->form->sale_price = ($this->form->initial_price != '') ? $this->form->initial_price : 0;
            $this->form->sale_price = number_format($this->form->sale_price, 0, ',', '.');
        }
        $this->form->initial_price = ($this->form->initial_price != '') ? $this->form->initial_price : 0;
        $this->form->initial_price = number_format($this->form->initial_price, 0, ',', '.');
    }

    protected $validationAttributes = [
        'form.name' => 'nama',
        'form.initial_price' => 'harga awal',
        'form.percentage_profit' => 'persentase keuntungan',
        'form.sale_price' => 'harga jual',
        'form.stock' => 'stok',
        'form.categoryProduct' => 'kategori produk',
        'form.unit_id' => 'satuan produk',
    ];
}
