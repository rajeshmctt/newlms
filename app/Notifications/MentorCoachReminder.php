<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentorCoachReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $blogCount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($assignment, $blogCount)
    {
        $this->blogCount = $blogCount;

        $this->connection = 'database';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.user.mentor_coach_reminder', ['notifiable' => $notifiable, 'blogCount' => $this->blogCount])->subject('Session '.$this->blogCount.' Mentor Coach 1x1 Reminder');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
