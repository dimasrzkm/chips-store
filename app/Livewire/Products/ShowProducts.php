<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;

    public ProductForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete($product)
    {
        $this->form->setPost(Product::find($product['id']));
    }

    public function deleteProduct()
    {
        $this->form->destroy();

        $this->redirectRoute('products.index', navigate: true);
    }

    #[Title('Data Produk')]
    public function render()
    {
        $products = Product::orderBy('name')->paginate($this->form->showPerPage, pageName: 'product-page');
        if ($this->form->search != '') {
            $products = Product::where('name', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'product-page');
        }

        return view('livewire.products.show-products', ['products' => $products]);
    }
}
