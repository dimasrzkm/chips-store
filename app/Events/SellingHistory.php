<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SellingHistory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $allProducts;

    public $modeEvent;

    /**
     * Create a new event instance.
     */
    public function __construct($data, $mode = 'tambah')
    {
        $this->allProducts = $data;
        $this->modeEvent = $mode;
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
