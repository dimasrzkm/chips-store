<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Component;

class EditProducts extends Component
{
    public ProductForm $form;

    public function mount(Product $product)
    {
        $this->form->setPost($product);
    }

    public function submit()
    {
        $this->validate();
        $this->form->update();

        return $this->redirectRoute('products.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.products.edit-products');
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
    ];
}
