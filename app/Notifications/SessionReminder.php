<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;

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
        $facultyEmails = [];
        if($this->session->batch->faculties) foreach($this->session->batch->faculties as $faculty){
            $facultyEmails[] = $faculty->email;
        }

        return (new MailMessage)->markdown('mail.user.session_reminder', ['notifiable' => $notifiable, 'session' => $this->session])->cc($facultyEmails)->subject('Session Reminder for Program: '.$this->session->batch->program->name);
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
