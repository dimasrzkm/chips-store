<?php

namespace App\Livewire\Forms;

use App\Events\ConsigmentHistory;
use App\Models\Consigment;
use App\Models\Konsinyor;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Form;

class ConsigmentForm extends Form
{
    public ?Consigment $consigment;

    // data for input
    public $number_transaction;

    public $transaction_code;

    public $user_id;

    public $consigment_date;

    public $konsinyor_id;

    // variable tambahan untuk dinamic konsinyor dan produk
    public $allProducts;

    public $allKonsinyors;

    public $selectedProducts = [];

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $showPerPage = 10;

    public function setPost(Consigment $consigment)
    {
        $this->consigment = $consigment;
        $this->transaction_code = $consigment->transaction_code;

        foreach ($consigment->products as $product) {
            $this->selectedProducts[] = [
                'product_id' => $product['id'],
                'quantity' => $product['pivot']['total_consigment'],
            ];
        }
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            $consigment = Consigment::create($this->only(['user_id', 'number_transaction', 'transaction_code', 'consigment_date']));
            // dd($this->selectedProducts);
            if (!empty($this->selectedProducts)) {
                foreach ($this->selectedProducts as $selected) {
                    $product = Product::find($selected['product_id']);
                    $consigment->products()->attach([
                        $product->id => [
                            'product_name' => $product->name,
                            'konsinyor_name' => $product->konsinyor->name,
                            'total_consigment' => $selected['quantity'],
                        ],
                    ]);
                }
                DB::commit();
                ConsigmentHistory::dispatch($this->selectedProducts);
                session()->flash('status', 'berhasil memasukan data pengeluaran stock');
                $this->reset('selectedProducts');
            } else {
                session()->flash('status', 'gagal memasukan data pengeluaran stock');
                DB::rollBack();
            }
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
            $this->consigment->delete();
            session()->flash('status', 'berhasil menghapus data penitipan produk');
            DB::commit();
            ConsigmentHistory::dispatch($this->selectedProducts, 'hapus');
            $this->reset('consigment', 'transaction_code', 'konsinyor_id', 'selectedProducts');
        } catch (\Exception $e) {
            info($e->getMessage());
            session()->flash('status', 'gagal menghapus data penitipan produk');
            DB::rollBack();
        }
    }

    public function rules()
    {
        return [
            'consigment_date' => ['required'],
            'konsinyor_id' => ['required'],
            'selectedProducts' => ['required', 'array', 'min:1']
        ];
    }
}
