<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StartPeerCoachingReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sessionsCount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sessionsCount)
    {
        $this->sessionsCount = $sessionsCount;

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
        return (new MailMessage)->markdown('mail.user.start_peer_coaching_reminder', ['notifiable' => $notifiable, 'sessionsCount' => $this->sessionsCount])->subject('Reminder: Start Peer Coaching');
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
