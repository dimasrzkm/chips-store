<?php

namespace App\Livewire\Reports\Consigments;

use App\Events\PaidOffConsigment;
use App\Models\Consigment;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;
use Livewire\Component;

class ShowReportConsigments extends Component
{
    public $consigmentId;

    public $selectedConsigment = [];

    #[Title('Pelunasan Penitipan Produk')]
    public function render()
    {
        return view('livewire.reports.consigments.show-report-consigments', [
            'consigments' => Consigment::where('is_paid_off', false)->get(),
        ]);
    }

    public function updatedConsigmentId($data)
    {
        $this->selectedConsigment = Consigment::with('products')->find($data);
    }

    public function printPayment()
    {
        $this->validate();

        // return to_route('laporan.pelunasan', [
        //     'consigmentId' => $this->consigmentId,
        // ]);

        // $consigments = Consigment::with('products')->find($this->consigmentId);
        // if (! is_null($consigments)) {
        //     $pdf = Pdf::loadView('pdf.payments', [
        //         'consigmentDate' => $consigments->consigment_date, // mengambil tanggal penitipan produk
        //         'products' => $consigmentsProduct = $consigments->products, // mengambil data produk yang dititipkan
        //         'konsinyorName' => $consigmentsProduct[0]->pivot->konsinyor_name, // nama penitip
        //         'nameMakingReport' => auth()->user()->name, // nama pembuat laporan
        //     ])->setPaper('a4', 'landscape')->output();
        //     if (! $consigments->is_paid_off) {
        //         PaidOffConsigment::dispatch($consigments); // menjalankan event untuk pengurangan stok
        //     } else {
        //         $this->reset('selectedConsigment');

        //         return back()->with('status', 'Produk titipan dengan nomor transaksi '.$consigments->transaction_code.' telah dilunaskan');
        //     }

        //     return response()->streamDownload(
        //         fn () => print($pdf),
        //         'bukti_pelunasan.pdf'
        //     );
        // } else {
        //     $this->reset('consigmentId');

        //     return back()->with('status', 'Pilih No Transaksi Penitipan!');
        // }
    }

    public function rules()
    {
        return [
            'consigmentId' => ['required'],
        ];
    }

    protected $validationAttributes = [
        'consigmentId' => 'Kode Transaksi Titipan',
    ];
}
