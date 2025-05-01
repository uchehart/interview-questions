<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WateringEventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'zone_id' => $this->zone_id,
            'status' => $this->status,
            'started_at' => $this->started_at,
            'stopped_at' => $this->stopped_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}