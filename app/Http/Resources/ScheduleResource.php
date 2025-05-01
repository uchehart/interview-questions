<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'zone_id' => $this->zone_id,
            'start_time' => $this->start_time,
            'duration' => $this->duration,
            'days_of_week' => $this->days_of_week,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}