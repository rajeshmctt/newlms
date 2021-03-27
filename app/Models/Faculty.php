<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notifications\UserForgotPassword;

use App\Notifications\UserAssignmentSubmission as UserAssignmentSubmissionNotification;

use Kyslik\ColumnSortable\Sortable;

class Faculty extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Sortable;

    protected $guard = 'faculty';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'location_id', 'first_name', 'last_name', 'email', 'password', 'country_code', 'phone', 'photo', 'description', 'long_description', 'last_logged_in_at', 'logged_in_at', 'status',
    ];

    public $sortable = ['id', 'first_name', 'last_name', 'email', 'phone', 'status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_logged_in_at' => 'datetime',
        'logged_in_at' => 'datetime',
    ];
    
    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = url('/').'/reset-password?email='.$this->email.'&token='.$token;

        $this->notify(new UserForgotPassword($url));
    }
    
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_faculty');
    }

    public function mentorCoachBatches()
    {
        return $this->belongsToMany(Batch::class, 'batch_mentor_coach', 'faculty_id', 'batch_id');
    }
    
    public function electives()
    {
        return $this->belongsToMany(Elective::class, 'elective_faculty');
    }
    
    public function coachTypes()
    {
        return $this->belongsToMany(CoachType::class, 'faculty_coach_type');
    }

    public function activeFacultyBatchesCount()
    {
        return $this->batches()->where(['batches.status' => 'active'])->count();
    }

    public function activeMentorCoachBatchesCount()
    {
        return $this->mentorCoachBatches()->where(['batches.status' => 'active'])->count();
    }

    // Notifications

    public function sendUserAssignmentSubmissionNotification($batch, $pUser, $userAssignment) { 
        $this->notify(new UserAssignmentSubmissionNotification($batch, $pUser, $userAssignment));
    }
}
