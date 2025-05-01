<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Resources\ZoneResource;
use App\Http\Requests\ZoneRequest;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::all();
        return ZoneResource::collection($zones);
    }

    public function store(ZoneRequest $request)
    {
        $zone = Zone::create($request->validated());
        return new ZoneResource($zone);
    }

    public function show(Zone $zone)
    {
        return new ZoneResource($zone);
    }

    public function update(ZoneRequest $request, Zone $zone)
    {
        $zone->update($request->validated());
        return new ZoneResource($zone);
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return response()->json(null, 204);
    }
}