<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProgramNewAssignment extends Notification implements ShouldQueue
{
    use Queueable;

    protected $batch;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($batch)
    {
        $this->batch = $batch;

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
        if($this->batch->faculties) foreach($this->batch->faculties as $faculty){
            $facultyEmails[] = $faculty->email;
        }

        return (new MailMessage)->markdown('mail.user.program_new_assignment', ['notifiable' => $notifiable, 'batch' => $this->batch])->cc($facultyEmails)->subject('Assignment Uploaded for Program: '.$this->batch->program->name);
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
