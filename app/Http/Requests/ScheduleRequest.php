<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust based on your authorization logic
    }

    public function rules()
    {
        return [
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|string',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ];
    }
}