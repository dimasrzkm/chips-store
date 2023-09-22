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
        foreach ($event->allIngridients as $data) {
            $stock = Stock::find($data['stock_id']);
            if (strtolower($stock->name) == 'pisang') {
                $this->quantityForProduct += $data['quantity'];
            }
            $stock->total = ($event->modeEventStock == 'hapus') ? $stock->total + $data['quantity'] : $stock->total - $data['quantity'];
            $stock->update(['total']);
        }

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
