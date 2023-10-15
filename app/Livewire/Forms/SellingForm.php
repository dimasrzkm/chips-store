<?php

namespace App\Livewire\Forms;

use App\Events\SellingHistory;
use App\Models\Product;
use App\Models\Selling;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Form;

class SellingForm extends Form
{
    public ?Selling $selling;

    public $user_id;

    public $number_transaction;

    public $transaction_code;

    public $selling_date;

    public $total;

    public $nominal_payment;

    public $nominal_return;

    public $allProducts;

    public $product_id;

    public $product;

    public $sale_price;

    public $stock;

    public $quantity;

    public $purchase_unit;

    public $selected_purchase_unit;

    public $selectedProducts;

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public $receiptName;

    public function setPost(Selling $selling)
    {
        $this->selling = $selling;
        $this->transaction_code = $selling->transaction_code;

        foreach ($selling->products as $product) {
            $this->selectedProducts[] = [
                'id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $product['pivot']['quantity'],
                'sub_total' => $product['pivot']['sub_total'],
                'selected_purchase_unit' => $product['pivot']['purchase_unit'],
            ];
        }
    }

    public function create()
    {
        DB::beginTransaction();
        if ($this->nominal_payment >= $this->total) {
            try {
                $selling = Selling::create($this->only(['user_id', 'number_transaction', 'transaction_code', 'selling_date', 'total', 'nominal_payment', 'nominal_return']));
                if (! empty($this->selectedProducts)) {
                    foreach ($this->selectedProducts as $select) {
                        $product = Product::where('name', $select['name'])->first();
                        // cek apakah unit yang dijual merupakan sekilo atau pcs
                        if ($select['selected_purchase_unit'] == 'sekilo' || $select['selected_purchase_unit'] == 'pcs') {
                            // maka cek terlebih dahulu dengan stock di produk
                            $tempQuantity = ($product->stock >= $select['quantity']) ? $select['quantity'] : '';
                        } else {
                            $tempQuantity = $select['quantity'];
                        }
                        $selling->products()->attach([
                            $product->id => [
                                'product_name' => $select['name'],
                                'quantity' => $tempQuantity,
                                'sub_total' => $select['sub_total'],
                                'purchase_unit' => $select['selected_purchase_unit'],
                            ],
                        ]);
                    }
                    DB::commit();
                    SellingHistory::dispatch($this->selectedProducts);
                    session()->flash('status', 'Pembelian berhasil!');
                    $this->reset('user_id', 'number_transaction', 'transaction_code', 'selling_date', 'total', 'nominal_payment', 'nominal_return');
                } else {
                    DB::rollBack();
                    session()->flash('status', 'Pembelian gagal!');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('status', 'Pembelian gagal!');
            }
        } else {
            DB::rollBack();
            session()->flash('status', 'Pembelian gagal!');
        }
    }

    public function destroy()
    {
        DB::beginTransaction();
        try {
            $this->selling->delete();
            session()->flash('status', 'berhasil menghapus data penjualan');
            DB::commit();
            SellingHistory::dispatch($this->selectedProducts, 'hapus');
            $this->reset('selling', 'transaction_code');
        } catch (\Exception $e) {
            info($e->getMessage());
            session()->flash('status', 'gagal menghapus data penjualan');
            DB::rollBack();
        }
    }

    public function rules()
    {
        return [
            'nominal_payment' => ['required', 'numeric'],
        ];
    }
}
