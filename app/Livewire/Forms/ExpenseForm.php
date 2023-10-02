<?php

namespace App\Livewire\Forms;

use App\Events\StockHistory;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Form;

class ExpenseForm extends Form
{
    public ?Expense $expense;

    // data for input
    public $number_transaction;

    public $transaction_code;

    public $user_id;

    public $expense_date;

    // variable tambahan untuk dinamic bahan dan produk
    public $allProducts;

    public $product_id;

    public $allStocks;

    public $selectedStocks = [];

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public function setPost(Expense $expense)
    {
        $this->expense = $expense;
        $this->transaction_code = $expense->transaction_code;
        $this->product_id = $this->expense->products[0]->id;

        foreach ($expense->stocks as $ingridient) {
            $this->selectedStocks[] = [
                'stock_id' => $ingridient['id'],
                'quantity' => $ingridient['pivot']['total_used'],
            ];
        }
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            $expense = Expense::create($this->only(['user_id', 'number_transaction', 'transaction_code', 'expense_date']));
            $product = Product::find($this->product_id);
            foreach ($this->selectedStocks as $selected) {
                $stock = Stock::find($selected['stock_id']);
                $expense->stocks()->attach([
                    $selected['stock_id'] => [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'stock_name' => $stock->name,
                        'total_used' => ($stock->remaining_stock >= $selected['quantity']) ? $selected['quantity'] : '',
                        'unit' => $stock->unit->name,
                    ],
                ]);

            }
            DB::commit();
            StockHistory::dispatch($this->selectedStocks, $this->product_id);
            session()->flash('status', 'berhasil memasukan data pengeluaran stock');
        } catch (\Exception $e) {
            info($e->getMessage());
            session()->flash('status', 'gagal memasukan data pengeluaran stock');
            DB::rollBack();
        }
    }

    public function destroy()
    {
        DB::beginTransaction();
        try {
            $this->expense->delete();
            session()->flash('status', 'berhasil menghapus data pengeluaran stock');
            DB::commit();
            StockHistory::dispatch($this->selectedStocks, $this->product_id, 'hapus');
            $this->reset('expense', 'transaction_code', 'product_id', 'selectedStocks');
        } catch (\Exception $e) {
            info($e->getMessage());
            session()->flash('status', 'gagal menghapus data pengeluaran stock');
            DB::rollBack();
        }
    }

    public function rules()
    {
        return [
            'expense_date' => ['required'],
            'product_id' => ['required'],
        ];
    }
}
