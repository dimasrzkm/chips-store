<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ShowExpenses extends Component
{
    use WithPagination;

    public ExpenseForm $form;

    public function setHowMuchPageShow($total)
    {
        $this->form->showPerPage = $total;
    }

    public function getDataForDelete(Expense $expense)
    {
        $this->form->setPost($expense);
    }

    public function deleteExpense()
    {
        $this->form->destroy();
    }

    #[Title('Data Pengeluaran Stock')]
    public function render()
    {
        $expenses = Expense::with(['user', 'stocks'])
            ->orderBy('transaction_code', 'desc')
            ->paginate($this->form->showPerPage, pageName: 'pengeluaran-page');

        if ($this->form->search != '') {
            $expenses = Expense::with(['user', 'stocks'])
                ->whereHas('user', function (Builder $query) {
                    return $query->where('name', 'like', '%'.$this->form->search.'%');
                })
                ->orWhere('transaction_code', 'like', '%'.$this->form->search.'%')
                ->orWhere('expense_date', 'like', '%'.$this->form->search.'%')
                ->orderBy('transaction_code', 'desc')
                ->paginate($this->form->showPerPage, pageName: 'pengeluaran-page');
        }

        return view('livewire.expenses.show-expenses', ['expenses' => $expenses]);
    }
}
