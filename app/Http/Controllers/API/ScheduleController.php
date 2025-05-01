<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Resources\ScheduleResource;
use App\Http\Requests\ScheduleRequest;
use App\Mail\ScheduleNotification;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
    public function index(Zone $zone)
    {
        $schedules = $zone->schedules;
        return ScheduleResource::collection($schedules);
    }

    public function store(ScheduleRequest $request, Zone $zone)
    {
        $schedule = $zone->schedules()->create($request->validated());

        // Send email notification to admin
        Mail::to('admin@cashcardng.com')->send(new ScheduleNotification($schedule, 'created'));

        return new ScheduleResource($schedule);
    }

    public function show(Zone $zone, Schedule $schedule)
    {
        if ($schedule->zone_id !== $zone->id) {
            return response()->json(['error' => 'Schedule not found for this zone'], 404);
        }

        return new ScheduleResource($schedule);
    }

    public function update(ScheduleRequest $request, Zone $zone, Schedule $schedule)
    {
        if ($schedule->zone_id !== $zone->id) {
            return response()->json(['error' => 'Schedule not found for this zone'], 404);
        }

        $schedule->update($request->validated());

        // Send email notification to admin
        Mail::to('admin@cashcardng.com')->send(new ScheduleNotification($schedule, 'updated'));

        return new ScheduleResource($schedule);
    }

    public function destroy(Zone $zone, Schedule $schedule)
    {
        if ($schedule->zone_id !== $zone->id) {
            return response()->json(['error' => 'Schedule not found for this zone'], 404);
        }

        $schedule->delete();
        return response()->json(null, 204);
    }
}
