<?php

namespace App\Livewire\Reports\Sellings;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class ShowReportSellings extends Component
{
    public $tanggal_awal;

    public $tanggal_akhir;

    #[Title('Laporan Penjualan')]
    public function render()
    {
        return view('livewire.reports.sellings.show-report-sellings');
    }

    public function exportAs($export)
    {
        $this->validate();
        $products = DB::table('sellings_detail as pivot')
            ->leftJoin('sellings', 'pivot.selling_id', '=', 'sellings.id')
            ->leftJoin('products', 'pivot.product_id', '=', 'products.id')
            ->leftJoin('konsinyors', 'products.konsinyor_id', '=', 'konsinyors.id')
            ->select('sellings.selling_date', 'pivot.product_name', 'products.initial_price', 'products.sale_price', 'pivot.quantity', 'pivot.purchase_unit', 'pivot.sub_total', 'konsinyors.name as name_konsinyor')
            ->whereNull('konsinyors.name')
            ->whereBetween('sellings.selling_date', [$this->tanggal_awal, $this->tanggal_akhir])
            ->get();
        // dd($products);

        $productsForExport = [];

        $sorProductByName = [];
        // mengambil produk yang bukan titipan
        $productWithoutConsigment = Product::whereDoesntHave('konsinyor')->pluck('name');
        foreach ($productWithoutConsigment as $data) {
            $sorProductByName[] = $products->filter(function ($product) use ($data) {
                return strtolower($product->product_name) == strtolower($data);
            });
        }
        // dd($sorProductByName);

        $sortProductByNameAndUnit = [];
        foreach ($sorProductByName as $produkUtama) {
            $tempya = ['seperempat', 'setengah', 'sekilo'];
            foreach ($tempya as $data) {
                $sortProductByNameAndUnit[] = $produkUtama->filter(function ($product) use ($data) {
                    return $product->purchase_unit == $data;
                })->values();
            }
        }
        // dd($sortProductByNameAndUnit);

        foreach ($sortProductByNameAndUnit as $i => $data) {
            $total = 0;
            foreach ($data as $index => $item) {
                $temp = $data[$index];
                $total += $item->quantity;
            }
            if (! empty($sortProductByNameAndUnit[$i][0])) {
                // info('jalan ke iterasi-'.$i);
                if ($temp->purchase_unit == 'seperempat') {
                    $margin = $total * $temp->initial_price;
                } elseif ($temp->purchase_unit == 'setengah') {
                    $margin = $total * $temp->initial_price * 2;
                } else {
                    $margin = $total * $temp->initial_price * 4;
                }
                $productsForExport[] = [
                    'product_name' => $temp->product_name,
                    'initial_price' => $temp->initial_price,
                    'sale_price' => $temp->sale_price,
                    'quantity' => $total,
                    'purchase_unit' => $temp->purchase_unit,
                    'total' => $total * $temp->sub_total,
                    'margin' => $total * $temp->sub_total - $margin,
                ];
            }
            $total = 0;
        }

        // dd($productsForExport);
        // dd($this->tanggal_akhir->format('d F Y'));
        $pdf = Pdf::loadView('pdf.sellings', [
            'datas' => $productsForExport,
            'tanggal_awal' => Carbon::parse($this->tanggal_awal)->format('d F Y'),
            'tanggal_akhir' => Carbon::parse($this->tanggal_akhir)->format('d F Y'),
        ])->setPaper('a4', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'laporan_penjualan.pdf'
        );
    }

    public function rules()
    {
        return [
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date'],
        ];
    }

    protected $validationAttributes = [
        'tanggal_awal' => 'tanggal awal',
        'tanggal_akhir' => 'tanggal akhir',
    ];
}
