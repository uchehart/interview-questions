<?php

namespace App\Listeners;

use App\Events\ScheduleUpdated;
use App\Jobs\SendScheduleNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendScheduleUpdatedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param ScheduleUpdated $event
     * @return void
     */
    public function handle(ScheduleUpdated $event)
    {
        SendScheduleNotificationJob::dispatch($event->schedule, 'updated');
    }
}
