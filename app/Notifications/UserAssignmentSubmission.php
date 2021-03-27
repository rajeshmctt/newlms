<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserAssignmentSubmission extends Notification implements ShouldQueue
{
    use Queueable;

    protected $batch;
    protected $pUser;
    protected $userAssignment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($batch, $pUser, $userAssignment)
    {
        $this->batch = $batch;
        $this->pUser = $pUser;
        $this->userAssignment = $userAssignment;

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
        return (new MailMessage)->markdown('mail.user.user_assignment_submition', ['notifiable' => $notifiable, 'batch' => $this->batch, 'pUser' => $this->pUser, 'userAssignment' => $this->userAssignment])->cc($this->pUser->email)->subject('Assignment Submission for Program: '.$this->batch->program->name.' by '.$this->pUser->first_name.' '.$this->pUser->last_name);
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
