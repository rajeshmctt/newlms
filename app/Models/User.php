<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notifications\UserForgotPassword;

use App\Notifications\ProgramWelcome as ProgramWelcomeNotification;
use App\Notifications\ProgramPreRead as ProgramPreReadNotification;
use App\Notifications\ElectivePreRead as ElectivePreReadNotification;
use App\Notifications\ProgramNewAssignment as ProgramNewAssignmentNotification;
use App\Notifications\AssignmentReminder as AssignmentReminderNotification;
use App\Notifications\SessionReminder as SessionReminderNotification;
use App\Notifications\StartPeerCoachingReminder as StartPeerCoachingReminderNotification;
use App\Notifications\BlogReminder as BlogReminderNotification;
use App\Notifications\MentorCoachReminder as MentorCoachReminderNotification;

use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'location_id', 'current_role_id', 'current_function_id', 'first_name', 'last_name', 'email', 'password', 'country_code', 'phone', 'photo', 'description', 'current_organisation_name', 'current_organisation_website', 'facebook_profile_url', 'linkedin_profile_url', 'instagram_profile_url', 'twitter_profile_url', 'last_logged_in_at', 'logged_in_at', 'status',
    ];

    public $sortable = ['id', 'first_name', 'email', 'phone', 'status'];

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
    
    public function profileCompletion()
    {
        $profileCompletion = 0;
        if($this->first_name) $profileCompletion += 4;
        if($this->last_name) $profileCompletion += 4;
        if($this->phone) $profileCompletion += 4;
        if($this->email) $profileCompletion += 4;
        if($this->country_id) $profileCompletion += 4;
        if($this->location_id) $profileCompletion += 4;
        if($this->current_function_id) $profileCompletion += 4;
        if($this->current_role_id) $profileCompletion += 4;
        if($this->current_organisation_name) $profileCompletion += 4;
        if($this->currentCredentials->count()) $profileCompletion += 4;
        if($this->photo && $this->photo != 'default.png') $profileCompletion += 30;

        $socialProfilesCount = 0;
        if($this->facebook_profile_url) $socialProfilesCount++;
        if($this->linkedin_profile_url) $socialProfilesCount++;
        if($this->instagram_profile_url) $socialProfilesCount++;
        if($this->twitter_profile_url) $socialProfilesCount++;

        if($socialProfilesCount == 1) $profileCompletion += 10;
        elseif($socialProfilesCount == 2) $profileCompletion += 20;
        elseif($socialProfilesCount > 2) $profileCompletion += 30;

        return $profileCompletion;
    }
    
    public function currentCredentials()
    {
        return $this->belongsToMany(CurrentCredential::class, 'user_current_credential');
    }
    
    public function batches()
    {
        return $this->belongsToMany(Batch::class, BatchUser::class);
    }
    
    public function batchUsers()
    {
        return $this->hasMany(BatchUser::class);
    }

    public function electiveBatchUsers()
    {
        return $this->hasMany(BatchUser::class)->whereNotNull('parent_batch_id');
    }

    public function userElectives()
    {
        return $this->hasMany(UserElective::class);
    }

    public function activeProgramsCount()
    {
        return $this->batches()->where(['batch_users.status' => 'active', 'batches.status' => 'active'])->whereNull('batch_users.parent_batch_id')->count();
    }

    public function activeElectivesCount()
    {
        return $this->batches()->where(['batch_users.status' => 'active', 'batches.status' => 'active'])->whereNotNull('batch_users.parent_batch_id')->count();
    }

    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }

    public function userElectiveAssignments()
    {
        return $this->hasMany(UserElectiveAssignment::class);
    }

    public function currentRole()
    {
        return $this->belongsTo(CurrentRole::class);
    }
    
    public function currentFunction()
    {
        return $this->belongsTo(CurrentFunction::class);
    }
        
    public function resources()
    {
        return $this->belongsToMany(Resource::class, UserResource::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function mentorCoachSessions()
    {
        return $this->hasMany(MentorCoachSession::class);
    }

    public function programFeedbacks()
    {
        return $this->hasMany(ProgramFeedback::class)->latest();
    }

    public function electiveFeedbacks()
    {
        return $this->hasMany(ElectiveFeedback::class)->latest();
    }

    public function batchJourneys()
    {
        return $this->hasMany(BatchJourney::class)->latest();
    }

    public function electiveBatchJourneys()
    {
        return $this->hasMany(ElectiveBatchJourney::class)->latest();
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Notifications

    public function sendPasswordResetNotification($token)
    {
        $url = url('/').'/reset-password?email='.$this->email.'&token='.$token;

        $this->notify(new UserForgotPassword($url));
    }

    public function sendProgramWelcomeNotification($batch) { 
        $this->notify(new ProgramWelcomeNotification($batch));
    }

    public function sendProgramPreReadNotification($batch) { 
        $this->notify(new ProgramPreReadNotification($batch));
    }

    public function sendElectivePreReadNotification($batch) { 
        $this->notify(new ElectivePreReadNotification($batch));
    }

    public function sendProgramNewAssignmentNotification($batch) { 
        $this->notify(new ProgramNewAssignmentNotification($batch));
    }

    public function sendAssignmentReminderNotification($assignment) { 
        $this->notify(new AssignmentReminderNotification($assignment));
    }

    public function sendSessionReminderNotification($session) { 
        $this->notify(new SessionReminderNotification($session));
    }

    public function sendStartPeerCoachingReminderNotification($sessionsCount) { 
        $this->notify(new StartPeerCoachingReminderNotification($sessionsCount));
    }

    public function sendBlogReminderNotification($assignment, $blogCount) { 
        $this->notify(new BlogReminderNotification($assignment, $blogCount));
    }

    public function sendMentorCoachReminderNotification($blogCount) { 
        $this->notify(new MentorCoachReminderNotification($blogCount));
    }
}
