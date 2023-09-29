<?php

namespace App\Livewire\Sellings;

use App\Livewire\Forms\SellingForm;
use App\Models\Product;
use App\Models\Selling;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateSellings extends Component
{
    public SellingForm $form;

    public function mount()
    {
        $this->form->number_transaction = (Selling::latest()->first()) ? Selling::latest()->first()->number_transaction + 1 : 1;
        $this->form->transaction_code = 'TPP-'.str_pad($this->form->number_transaction, 4, '0', STR_PAD_LEFT);

        $this->form->user_id = auth()->user()->id;
        $this->form->selling_date = now()->format('Y-m-d');

        $this->form->allProducts = Product::where('stock', '>', 0)->get();
    }

    #[Title('Penjualan Produk')]
    public function render()
    {
        return view('livewire.sellings.create-sellings');
    }

    public function submit()
    {
        $this->validate();
        $this->form->create();

        return $this->redirectRoute('sellings.index', navigate: true);
    }

    public function updatedFormProductId($data)
    {

        $product = Product::with('unit')->find($data); //mencari data product berdasarkan id yang dipilih
        if (! is_null($product)) {
            $this->form->product = $product->toArray(); // menyimpan data pada product
            $this->form->sale_price = $product->sale_price; // menyimpan data harga jual
            $this->form->stock = $product->stock; // menyimpan stock produk tersedia
            $this->form->purchase_unit = $product->unit->name; // menyimpan satuan produk
        } else {
            $this->reset('form.sale_price', 'form.stock');
        }

    }

    public function addPurchaseProduct()
    {
        try {
            $this->form->product['quantity'] = $this->form->quantity; // simpan pembelian product

            // cek apakah unit dari produk yang dipilih adalah kg
            if ($this->form->purchase_unit == 'kg') {
                $this->form->product['selected_purchase_unit'] = $this->form->selected_purchase_unit; // simpan jumlah beli (1/4,1/2,1 kg)
                // cek apakah unit dari pembelian yang dipiih adalah seperempat, setengah, dan sekilo
                switch ($this->form->selected_purchase_unit) {
                    case 'setengah':
                        $this->form->product['sub_total'] = $this->form->quantity * $this->form->sale_price * 2;
                        break;
                    case 'sekilo':
                        $this->form->product['sub_total'] = $this->form->quantity * $this->form->sale_price * 4;
                        break;
                    default:
                        $this->form->product['sub_total'] = $this->form->quantity * $this->form->sale_price;
                        break;
                }
            } else { // dijalankan jika unit yang dipilih bukan 1/4, 1/2, dan 1kg
                $this->form->product['selected_purchase_unit'] = $this->form->product['unit']['name'];
                $this->form->product['sub_total'] = $this->form->quantity * $this->form->sale_price; // simpan sub total pembelian product
            }

            $this->form->selectedProducts[] = $this->form->product; // menambah data tsb kedalam produk yang dibeli

            $this->form->total += $this->form->product['sub_total']; // menghitung sub total produk yang dibeli
            if ($this->form->nominal_payment) {
                $this->form->nominal_return = $this->form->nominal_payment - $this->form->total;
            }

            $this->reset('form.product_id', 'form.product', 'form.sale_price', 'form.stock', 'form.quantity', 'form.selected_purchase_unit');
        } catch (\Exception $e) {
            return back()->with('status', 'Pilih produk');
        }
    }

    public function removePurchaseProduct($index)
    {
        $this->form->total -= $this->form->selectedProducts[$index]['sub_total'];
        if ($this->form->nominal_payment) {
            $this->form->nominal_return = $this->form->nominal_payment - $this->form->total;
        }
        unset($this->form->selectedProducts[$index]);
        $this->form->selectedProducts = array_values($this->form->selectedProducts);
    }

    public function updatedFormNominalPayment($data)
    {
        $this->form->nominal_payment = ($data != '') ? (int) $data : 0;
        $this->form->nominal_return = $this->form->nominal_payment - $this->form->total;
    }

    protected $validationAttributes = [
        'form.nominal_payment' => 'Jumlah bayar',
    ];
}