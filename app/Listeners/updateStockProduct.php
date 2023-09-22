<?php

namespace App\Listeners;

use App\Events\ConsigmentHistory;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class updateStockProduct implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ConsigmentHistory $event): void
    {
        foreach ($event->allDataProducts as $data) {
            $product = Product::find($data['product_id']);
            $product->stock = ($event->modeEventProduct == 'hapus') ? $product->stock - $data['quantity'] : $product->stock + $data['quantity'];
            $product->update(['stock']);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(ConsigmentHistory $event, Throwable $exception): void
    {
        info('gagal di listener history product');
    }
}
