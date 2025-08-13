<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lat;
    public $lng;
    public $distance;
    public $withinRange;

    public function __construct($lat, $lng, $distance, $withinRange)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->distance = $distance;
        $this->withinRange = $withinRange;
    }

    public function broadcastOn()
    {
        return new Channel('location-tracking');
    }

    
}
