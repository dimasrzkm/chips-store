<?php

namespace App\Livewire\Consigments;

use App\Livewire\Forms\ConsigmentForm;
use App\Models\Consigment;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowConsigments extends Component
{
    use WithPagination;

    public ConsigmentForm $form;

    #[Title('Data Penitip Barang')]
    public function render()
    {
        $consigments = Consigment::with(['user', 'products'])
            ->orderBy('transaction_code', 'desc')->paginate($this->form->showPerPage, pageName: 'consigment-page');
        if ($this->form->search != '') {
            $consigments = Consigment::with(['user', 'products'])
                ->orWhereHas('products', function (Builder $query) {
                    return $query->where('name', 'like', '%'.$this->form->search.'%');
                })
                ->orWhereHas('user', function (Builder $query) {
                    return $query->where('name', 'like', '%'.$this->form->search.'%');
                })
                ->orWhere('transaction_code', 'like', '%'.$this->form->search.'%')
                ->orWhere('consigment_date', 'like', '%'.$this->form->search.'%')
                ->orderBy('transaction_code', 'desc')->paginate($this->form->showPerPage, pageName: 'consigment-page');
        }

        return view('livewire.consigments.show-consigments', [
            'consigments' => $consigments,
        ]);
    }

    public function getDataForDelete(Consigment $consigment)
    {
        $this->form->setPost($consigment);
    }

    public function deleteConsigment()
    {
        $this->form->destroy();
    }

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }
}
