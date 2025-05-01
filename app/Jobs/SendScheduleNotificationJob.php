<?php

namespace App\Jobs;

use App\Models\Schedule;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\Notifications\ScheduleNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;

class SendScheduleNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $schedule;
    protected $action;
    public $tries = 3;

    public function __construct(Schedule $schedule, string $action = 'updated')
    {
        $this->schedule = $schedule;
        $this->action = $action;
        $this->onQueue('notifications');
    }

    public function handle()
    {
        Notification::route('mail', config('irrigation.admin_email'))
            ->notify(new ScheduleNotification($this->schedule, $this->action));
    }
}