<?php

namespace App\Listeners;

use App\Events\SellingHistory;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class updateProductStock implements ShouldQueue
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
    public function handle(SellingHistory $event): void
    {
        // info($event->allProducts);
        $temp = 0;
        foreach ($event->allProducts as $data) {
            $product = Product::find($data['id']);
            if ($product['unit']['name'] == 'kg') {
                if ($data['selected_purchase_unit'] == 'sekilo') {
                    $temp = 4;
                } elseif ($data['selected_purchase_unit'] == 'setengah') {
                    $temp = 2;
                } else {
                    $temp = 1;
                }
                $product->stock = ($event->modeEvent != 'hapus') ? $product->stock - $data['quantity'] * 0.25 * $temp : $product->stock + $data['quantity'] * 0.25 * $temp;
            } else {
                $product->stock = ($event->modeEvent != 'hapus') ? $product->stock - $data['quantity'] : $product->stock + $data['quantity'];
            }
            $product->update(['stock']);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(SellingHistory $event, Throwable $exception): void
    {
        info('gagal di listener product');
    }
}
