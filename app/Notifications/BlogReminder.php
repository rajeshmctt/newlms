<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $assignment;
    protected $blogCount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($assignment, $blogCount)
    {
        $this->assignment = $assignment;
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
        return (new MailMessage)->markdown('mail.user.blog_reminder', ['notifiable' => $notifiable, 'assignment' => $this->assignment, 'blogCount' => $this->blogCount])->subject('Reminder : Blog '.$this->blogCount.' due');
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
