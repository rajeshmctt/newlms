<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Kyslik\ColumnSortable\Sortable;

class Batch extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'type_2', 'program_id', 'country_id', 'location_id', 'company_id', 'name', 'description', 'contact_person', 'contact_email', 'contact_phone', 'start_date', 'end_date', 'reg_start_date', 'reg_end_date', 'duration_hr', 'duration_min', 'start_time', 'end_time', 'frequency', 'session_information', 'zero_cost_electives', 'mentor_coach_meetings', 'status',
    ];
    
    public $sortable = ['id', 'name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'reg_start_date' => 'date:Y-m-d',
        'reg_end_date' => 'date:Y-m-d',
    ];
    
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, BatchUser::class)->withPivot('id')->whereNull('batch_users.deleted_at');
    }

    public function batchUser()
    {
        return $this->hasOne(BatchUser::class);
    }

    public function batchUsers()
    {
        return $this->hasMany(BatchUser::class);
    }
    
    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'batch_faculty');
    }

    public function mentorCoaches()
    {
        return $this->belongsToMany(Faculty::class, 'batch_mentor_coach', 'batch_id', 'faculty_id');
    }
    
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    
    public function electiveUsers()
    {
        return $this->belongsToMany(User::class, BatchUser::class, 'parent_batch_id', 'user_id');
    }

    public function mentorCoachSessions()
    {
        return $this->hasMany(MentorCoachSession::class);
    }
    
    public function courseJourneys()
    {
        return $this->hasMany(BatchJourney::class);
    }
    
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
    
    public function userResources()
    {
        return $this->hasMany(UserResource::class);
    }
}
