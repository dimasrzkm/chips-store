<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Stock;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateExpenses extends Component
{
    public ExpenseForm $form;

    public function mount()
    {
        $this->form->number_transaction = (Expense::latest()->first()) ? Expense::latest()->first()->number_transaction + 1 : 1;
        $this->form->transaction_code = 'PBB-'.str_pad($this->form->number_transaction, 4, '0', STR_PAD_LEFT);

        $this->form->user_id = auth()->user()->id;

        $this->form->allProducts = Product::whereDoesntHave('konsinyor')->get();
        $this->form->allStocks = Stock::where('remaining_stock', '>', 0)->get();
        $this->form->selectedStocks = [
            ['product_id' => '', 'quantity' => 1],
        ];
    }

    public function submit()
    {
        $this->validate();
        $this->form->create();

        return $this->redirectRoute('expenses.index', navigate: true);
    }

    #[Title('Tambah Pengeluaran Stock')]
    public function render()
    {
        return view('livewire.expenses.create-expenses');
    }

    public function addStock()
    {
        $this->form->selectedStocks[] = [];
    }

    public function removeStock($index)
    {
        unset($this->form->selectedStocks[$index]);
        $this->form->selectedStocks = array_values($this->form->selectedStocks);
    }

    protected $validationAttributes = [
        'form.expense_date' => 'tanggal pengeluaran',
        'form.product_id' => 'produk',
    ];
}
