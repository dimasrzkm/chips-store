<?php

namespace App\Livewire\Reports\Stocks;

use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

class ShowReportStocks extends Component
{
    public $tanggal_awal;

    public $tanggal_akhir;

    #[Title('Laporan Bahan Baku')]
    public function render()
    {
        return view('livewire.reports.stocks.show-report-stocks');
    }

    public function exportAs($export)
    {
        $this->validate();
        $stocks = Stock::with('expenses')
            ->whereBetween('purchase_date', [$this->tanggal_awal, $this->tanggal_akhir])
            ->get();

        $pdf = Pdf::loadView('pdf.stock', [
            'stocks' => $stocks,
            'tanggal_awal' => Carbon::parse($this->tanggal_awal)->format('d F Y'),
            'tanggal_akhir' => Carbon::parse($this->tanggal_akhir)->format('d F Y'),
        ])->setPaper('a4', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'laporan_bahan_baku.pdf'
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
