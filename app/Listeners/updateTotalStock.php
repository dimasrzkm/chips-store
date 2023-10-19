<?php

namespace App\Listeners;

use App\Events\StockHistory;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class updateTotalStock implements ShouldQueue
{
    public $quantityForProduct;

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
    public function handle(StockHistory $event): void
    {
        foreach ($event->allIngridients as $index => $data) {
            $stock = Stock::find($data['stock_id']);
            // info($stock);
            if ($index == 0) {
                $this->quantityForProduct += $data['quantity'];
            }
            // if (strtolower($stock->name) == 'pisang') { //bug ketika menginputkan data produk sendiri yang bukan pisang
            //     $this->quantityForProduct += $data['quantity'];
            // }
            $stock->remaining_stock = ($event->modeEventStock == 'hapus') ? $stock->remaining_stock + $data['quantity'] : $stock->remaining_stock - $data['quantity'];
            $stock->update(['remaining_stock']);
        }
        info($this->quantityForProduct);
        $product = Product::find($event->productId);
        $resultStock = ($event->modeEventStock == 'hapus') ? $product->stock - $this->quantityForProduct : $product->stock + $this->quantityForProduct;
        $product->update([
            'stock' => $resultStock,
        ]);

    }

    /**
     * Handle a job failure.
     */
    public function failed(StockHistory $event, Throwable $exception): void
    {
        info('gagal di listener history stock');
    }
}
