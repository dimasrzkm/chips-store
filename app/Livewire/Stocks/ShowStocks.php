<?php

namespace App\Livewire\Stocks;

use App\Livewire\Forms\StocksForm;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowStocks extends Component
{
    use WithPagination;

    public StocksForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete(Stock $stock)
    {
        $this->form->setPost($stock);
    }

    public function deleteStock()
    {
        $this->form->destroy();

        return $this->redirectRoute('stocks.index', navigate: true);
    }

    #[Title('Data Bahan Baku')]
    public function render()
    {
        $stocks = Stock::with('supplier')->orderby('purchase_date', 'desc')->paginate($this->form->showPerPage, pageName: 'stock-page');
        if ($this->form->search !== '') {
            $stocks = Stock::with('supplier')
                ->whereHas('supplier', function (Builder $query) {
                    return $query->where('name', 'like', '%'.$this->form->search.'%');
                })
                ->orWhere('name', 'like', '%'.$this->form->search.'%')
                ->orWhere('purchase_date', 'like', '%'.$this->form->search.'%')
                ->paginate($this->form->showPerPage, pageName: 'stock-page');
        }

        return view('livewire.stocks.show-stocks', [
            'stocks' => $stocks,
        ]);
    }
}
