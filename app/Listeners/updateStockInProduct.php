<?php

namespace App\Listeners;

use App\Events\PaidOffConsigment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class updateStockInProduct implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PaidOffConsigment $event): void
    {
        // perulangan data produk yang dititipkan
        foreach ($event->consigmentProducts as $product) {
            // mencari produk yang terjual selama penitipan berlangsung - hari pencetakan
            $productYangTerjualSelamaPenitipan = $product->sellings->filter(function ($prod) use ($event) {
                return $prod->selling_date->format('Y-m-d') >= $event->dateConsigment->format('Y-m-d')
                    && $prod->selling_date->format('Y-m-d') <= now()->format('Y-m-d');
            });
            // mencari jumlah beli produk
            $jumlahTerbeli = $productYangTerjualSelamaPenitipan->reduce(function ($acc, $next) {
                return $acc + $next->pivot->quantity;
            });
            // mencari jumlah barang yang harus dikembalikan
            foreach ($product->consigments as $consigment) {
                $jumlahKembali = $consigment->pivot->total_consigment - $jumlahTerbeli;
            }
            // mengubah stock pada produk - dengan jumlah barang yang harus dikembalikan
            $product->update(['stock' => $product->stock - $jumlahKembali]);
            // mengubah status titipan menjadi telah lunas dan memberikan keterangan tanggal berapa pelunasannya
            $event->consigmentData->update([
                'paid_off_date' => now()->format('Y-m-d'),
                'is_paid_off' => true,
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(PaidOffConsigment $event, Throwable $exception): void
    {
        info('gagal di listener update penitipan produk');
    }
}
