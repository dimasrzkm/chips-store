<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockHistory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $allIngridients;

    public $productId;

    public $modeEventStock;

    /**
     * Create a new event instance.
     */
    public function __construct($select, $id, $mode = 'tambah')
    {
        $this->allIngridients = $select;
        $this->productId = $id;
        $this->modeEventStock = $mode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
