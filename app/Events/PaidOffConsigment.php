<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaidOffConsigment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $consigmentData;

    public $consigmentProducts;

    public $dateConsigment;

    /**
     * Create a new event instance.
     */
    public function __construct($consigment)
    {
        $this->consigmentData = $consigment;
        $this->consigmentProducts = $consigment->products;
        $this->dateConsigment = $consigment->consigment_date;
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
