<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Batch;

class ProgramEnquiry extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;
    protected $batch;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Batch $batch)
    {
        $this->user = $user;
        $this->batch = $batch;

        $this->connection = 'database';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->cc($this->user->email)->subject('LMS: Enquiry on '.$this->batch->program->name)->markdown('emails.user.program_enquiry', ['user' => $this->user, 'batch' => $this->batch]);
    }
}
