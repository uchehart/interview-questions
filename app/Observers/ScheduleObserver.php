<?php

namespace App\Observers;

use App\Events\ScheduleCreated;
use App\Events\ScheduleUpdated;
use App\Models\Schedule;

class ScheduleObserver
{
    /**
     * Handle the Schedule "created" event.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function created(Schedule $schedule)
    {
        event(new ScheduleCreated($schedule));
    }

    /**
     * Handle the Schedule "updated" event.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function updated(Schedule $schedule)
    {
        event(new ScheduleUpdated($schedule));
    }
}
