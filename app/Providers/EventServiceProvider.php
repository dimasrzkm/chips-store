<?php

namespace App\Providers;

use App\Events\ConsigmentHistory;
use App\Events\GenerateReceipt;
use App\Events\PaidOffConsigment;
use App\Events\SellingHistory;
use App\Events\StockHistory;
use App\Listeners\saveReceiptToStorage;
use App\Listeners\updateProductStock;
use App\Listeners\updateStockInProduct;
use App\Listeners\updateStockProduct;
use App\Listeners\updateTotalStock;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StockHistory::class => [
            updateTotalStock::class,
        ],
        ConsigmentHistory::class => [
            updateStockProduct::class,
        ],
        SellingHistory::class => [
            updateProductStock::class,
        ],
        PaidOffConsigment::class => [
            updateStockInProduct::class,
        ],
        GenerateReceipt::class => [
            saveReceiptToStorage::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
