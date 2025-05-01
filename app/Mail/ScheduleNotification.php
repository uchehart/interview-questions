<?php

namespace App\Mail;

use App\Models\Schedule; // Added missing import
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduleNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The schedule instance.
     */
    protected $schedule;

    /**
     * The action being performed.
     */
    protected $action;

    /**
     * Create a new message instance.
     */
    public function __construct(Schedule $schedule, $action)
    {
        $this->schedule = $schedule;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Irrigation Schedule {$this->action}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.schedule-notification',
            with: [
                'schedule' => $this->schedule,
                'zone' => $this->schedule->zone,
                'action' => $this->action,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
