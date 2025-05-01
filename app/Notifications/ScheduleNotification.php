<?php

namespace App\Notifications;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $schedule;
    protected $action;

    /**
     * Create a new notification instance.
     *
     * @param Schedule $schedule
     * @param string $action
     * @return void
     */
    public function __construct(Schedule $schedule, string $action = 'updated')
    {
        $this->schedule = $schedule;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Irrigation Schedule ' . ucfirst($this->action))
            ->greeting('Hello Admin!')
            ->line('A schedule has been ' . $this->action . ' for zone: ' . $this->schedule->zone->name)
            ->line('Schedule Details:')
            ->line('- Start Time: ' . $this->schedule->start_time)
            ->line('- Duration: ' . $this->schedule->duration)
            ->line('- Days of Week: ' . implode(', ', $this->schedule->days_of_week))
            ->line('Please review these changes if necessary.')
            ->salutation('Regards, Your Irrigation System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'schedule_id' => $this->schedule->id,
            'zone_id' => $this->schedule->zone_id,
            'action' => $this->action,
        ];
    }
}
