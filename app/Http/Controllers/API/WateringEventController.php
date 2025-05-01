<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\WateringEvent;
use Illuminate\Http\Request;
use App\Http\Resources\WateringEventResource;
use Carbon\Carbon;

class WateringEventController extends Controller
{
    public function startWatering(Zone $zone)
    {
        // Check if the zone is already being watered
        $latestEvent = $zone->latestWateringEvent;

        if ($latestEvent && $latestEvent->status === 'started' && !$latestEvent->stopped_at) {
            return response()->json(['error' => 'Zone is already being watered'], 400);
        }

        // Create a new watering event
        $wateringEvent = $zone->wateringEvents()->create([
            'status' => 'started',
            'started_at' => Carbon::now(),
        ]);

        return new WateringEventResource($wateringEvent);
    }

    public function stopWatering(Zone $zone)
    {
        // Find the latest watering event for this zone
        $latestEvent = $zone->latestWateringEvent;

        if (!$latestEvent || $latestEvent->status !== 'started' || $latestEvent->stopped_at) {
            return response()->json(['error' => 'Zone is not currently being watered'], 400);
        }

        // Update the event
        $latestEvent->update([
            'status' => 'stopped',
            'stopped_at' => Carbon::now(),
        ]);

        return new WateringEventResource($latestEvent);
    }

    public function getStatus(Zone $zone)
    {
        $latestEvent = $zone->latestWateringEvent;

        $status = 'stopped';

        if ($latestEvent && $latestEvent->status === 'started' && !$latestEvent->stopped_at) {
            $status = 'watering';
        }

        return response()->json([
            'zone_id' => $zone->id,
            'zone_name' => $zone->name,
            'status' => $status,
            'latest_event' => $latestEvent ? new WateringEventResource($latestEvent) : null,
        ]);
    }
}
