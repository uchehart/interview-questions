<?php

namespace App\Listeners;

use App\Events\ScheduleCreated;
use App\Jobs\SendScheduleNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendScheduleCreatedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ScheduleCreated  $event
     * @return void
     */
    public function handle(ScheduleCreated $event)
    {
        // Dispatch a job to send notification
        SendScheduleNotificationJob::dispatch(
            $event->schedule,
            'created'
        );
    }
}
