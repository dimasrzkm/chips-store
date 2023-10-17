<?php

namespace App\Livewire\Sellings;

use App\Events\GenerateReceipt;
use App\Livewire\Forms\SellingForm;
use App\Models\Selling;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowSellings extends Component
{
    use WithPagination;

    public SellingForm $form;

    #[Title('Data Penjualan')]
    #[On('refreshSellings')]
    public function render()
    {
        $sellings = Selling::with(['products', 'user'])->orderBy('transaction_code', 'desc')->paginate($this->form->showPerPage, pageName: 'selling-page');
        if ($this->form->search != '') {
            $sellings = Selling::with(['products', 'user'])
                ->whereHas('user', function (Builder $query) {
                    return $query->where('name', 'like', '%'.$this->form->search.'%');
                })
                ->orWhere('selling_date', 'like', '%'.$this->form->search.'%')
                ->orWhere('transaction_code', 'like', '%'.$this->form->search.'%')
                ->orderBy('transaction_code', 'desc')
                ->paginate($this->form->showPerPage, pageName: 'selling-page');

        }

        return view('livewire.sellings.show-sellings', ['sellings' => $sellings]);
    }

    public function getDataForDelete(Selling $selling)
    {
        $this->form->setPost($selling);
    }

    public function deleteSelling()
    {
        $this->form->destroy();

        return $this->redirectRoute('sellings.index', navigate: true);
    }

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function printReceipt($selling)
    {
        GenerateReceipt::dispatch($selling);
    }

    public function getDataForQr($data)
    {
        $this->form->receiptName = $data['receipt']['name'];
    }
}
