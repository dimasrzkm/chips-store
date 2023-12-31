<?php

namespace App\Http\Controllers;

use App\Events\PaidOffConsigment;
use App\Models\Consigment;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function exportStock($tanggalAwal, $tanggalAkhir)
    {
        $tanggalAwal = Crypt::decryptString($tanggalAwal);
        $tanggalAkhir = Crypt::decryptString($tanggalAkhir);

        $stocks = Stock::with('expenses')
            ->whereBetween('purchase_date', [$tanggalAwal, $tanggalAkhir])
            ->get();

        return view('pdf.stock', [
            'stocks' => $stocks,
            'tanggal_awal' => Carbon::parse($tanggalAwal)->format('d F Y'),
            'tanggal_akhir' => Carbon::parse($tanggalAkhir)->format('d F Y'),
        ]);
    }

    public function exportPenjualan($tanggalAwal, $tanggalAkhir)
    {
        $tanggalAwal = Crypt::decryptString($tanggalAwal);
        $tanggalAkhir = Crypt::decryptString($tanggalAkhir);

        $products = DB::table('sellings_detail as pivot')
            ->leftJoin('sellings', 'pivot.selling_id', '=', 'sellings.id')
            ->leftJoin('products', 'pivot.product_id', '=', 'products.id')
            ->leftJoin('konsinyors', 'products.konsinyor_id', '=', 'konsinyors.id')
            ->select('sellings.selling_date', 'pivot.product_name', 'products.initial_price', 'products.sale_price', 'pivot.quantity', 'pivot.purchase_unit', 'pivot.sub_total', 'konsinyors.name as name_konsinyor')
            ->whereNull('konsinyors.name')
            ->whereBetween('sellings.selling_date', [$tanggalAwal, $tanggalAkhir])
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
            $tempya = ['seperempat', 'setengah', 'sekilo', 'pcs'];
            foreach ($tempya as $data) {
                $sortProductByNameAndUnit[] = $produkUtama->filter(function ($product) use ($data) {
                    return $product->purchase_unit == $data;
                })->values();
            }
        }
        // dd($sortProductByNameAndUnit);

        foreach ($sortProductByNameAndUnit as $i => $data) {
            $total = 0;
            $subTotal = 0;
            foreach ($data as $index => $item) {
                $temp = $data[$index];
                $total += $item->quantity;
                $subTotal += $item->sub_total;
            }
            if (! empty($sortProductByNameAndUnit[$i][0])) {
                // info('jalan ke iterasi-'.$i);
                if ($temp->purchase_unit == 'seperempat') {
                    $margin = $total * $temp->initial_price;
                } elseif ($temp->purchase_unit == 'setengah') {
                    $margin = $total * ($temp->initial_price * 2);
                } elseif ($temp->purchase_unit == 'sekilo') {
                    $margin = $total * ($temp->initial_price * 4);
                } else {
                    $margin = $total * ($temp->initial_price);
                }
                // dd($total, $subTotal,  $margin, $temp);
                $productsForExport[] = [
                    'product_name' => $temp->product_name,
                    'initial_price' => $temp->initial_price,
                    'sale_price' => $temp->sale_price,
                    'quantity' => $total,
                    'purchase_unit' => $temp->purchase_unit,
                    'total' => $subTotal,
                    'margin' => $subTotal - $margin,
                ];
            }
            $total = 0;
            $subTotal = 0;
        }

        return view('pdf.sellings', [
            'datas' => $productsForExport,
            'tanggal_awal' => Carbon::parse($tanggalAwal)->format('d F Y'),
            'tanggal_akhir' => Carbon::parse($tanggalAkhir)->format('d F Y'),
        ]);
    }

    public function exportStrukPenitipan($consigment)
    {
        // $test = json_decode(Crypt::decryptString($consigment), true);
        // dd($test);

        return view('pdf.consigments', [
            'consigment' => json_decode(Crypt::decryptString($consigment), true),
        ]);
    }

    public function exportPelunasan($consigmentId)
    {
        $consigmentId = Crypt::decryptString($consigmentId);

        $consigments = Consigment::with('products')->find($consigmentId);
        // dd($consigments);
        if (! is_null($consigments)) {
            // $pdf = Pdf::loadView('pdf.payments', [
            //     'consigmentDate' => $consigments->consigment_date, // mengambil tanggal penitipan produk
            //     'products' => $consigmentsProduct = $consigments->products, // mengambil data produk yang dititipkan
            //     'konsinyorName' => $consigmentsProduct[0]->pivot->konsinyor_name, // nama penitip
            //     'nameMakingReport' => auth()->user()->name, // nama pembuat laporan
            // ])->setPaper('a4', 'landscape')->output();
            if (! $consigments->is_paid_off) {
                PaidOffConsigment::dispatch($consigments); // menjalankan event untuk pengurangan stok
            } else {
                return back()->with('status', 'Produk titipan dengan nomor transaksi '.$consigments->transaction_code.' telah dilunaskan');
            }

            return view('pdf.payments', [
                'consigmentDate' => $consigments->consigment_date, // mengambil tanggal penitipan produk
                'products' => $consigmentsProduct = $consigments->products, // mengambil data produk yang dititipkan
                'konsinyorName' => $consigmentsProduct[0]->pivot->konsinyor_name, // nama penitip
                'nameMakingReport' => auth()->user()->name, // nama pembuat laporan
            ]);

            // return response()->streamDownload(
            //     fn () => print($pdf),
            //     'bukti_pelunasan.pdf'
            // );
        } else {
            $consigmentId = null;

            return back()->with('status', 'Pilih No Transaksi Penitipan!');
        }
    }

    public function exportStruk($selling)
    {
        return view('pdf.receipt', [
            'selling' => json_decode(Crypt::decryptString($selling), true),
        ]);
    }
}
