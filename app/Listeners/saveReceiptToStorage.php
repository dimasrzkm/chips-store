<?php

namespace App\Listeners;

use App\Events\GenerateReceipt;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Throwable;

class saveReceiptToStorage implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(GenerateReceipt $event)
    {
        $pdf = Pdf::loadView('pdf.receipt', [
            'selling' => $event->dataSelling,
        ])->setPaper('a4', 'potrait');
        $nameFile = md5($event->dataSelling['transaction_code'].microtime()).'.pdf';
        Storage::put("public/receipts/$nameFile", $pdf->output());
        Receipt::create([
            'selling_id' => $event->dataSelling['id'],
            'name' => $nameFile,
        ]);

        return to_route('sellings.index');
    }

    /**
     * Handle a job failure.
     */
    public function failed(GenerateReceipt $event, Throwable $exception): void
    {
        info('gagal di listener receipt');
    }
}
