<?php

namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferAccepted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;

    /**
     * Create a new event instance.
     */
    public function __construct(Ride $ride)
    {
        $this->ride = $ride;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel($this->ride->uuid)
        ];
    }

    // Broadcast data
    public function broadcastWith()
    {
        return [
            'ride_id' => $this->ride->id,
            'status' => 'accepted',
            'driver_id' => $this->ride->driver_id,
        ];
    }
}
