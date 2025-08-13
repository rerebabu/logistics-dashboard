<?php

namespace App\Listeners;

use App\Models\ProximityLog;
use App\Events\LocationUpdated;

class SaveProximityLog
{
    public function handle(LocationUpdated $event)
    {
        ProximityLog::create([
            'lat' => $event->lat,
            'lng' => $event->lng,
            'distance' => $event->distance,
            'within_range' => $event->withinRange
        ]);
    }
}
