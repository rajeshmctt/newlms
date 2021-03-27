<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

use Kyslik\ColumnSortable\Sortable;

class Program extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agreement_id', 'certification_level_id', 'label_id', 'currency_id', 'type', 'type_2', 'name', 'code', 'description', 'long_description', 'image', 'prerequisites', 'capacity', 'zero_cost_electives', 'who_is_it_for', 'what_you_will_gain', 'payment_mode', 'amount', 'mentor_coach_meetings', 'status',
    ];
    
    public $sortable = ['id', 'name', 'type'];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
    
    public function label()
    {
        return $this->belongsTo(Label::class);
    }
    
    public function certificationLevel()
    {
        return $this->belongsTo(CertificationLevel::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function batch()
    {
        return $this->hasOne(Batch::class);
    }

    public function upcomingBatch()
    {
        return $this->hasOne(Batch::class)->where('status', 'active')->whereDate('start_date', '>', Carbon::now())->orderBy('start_date');
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'program_faculty');
    }

    public function mentorCoaches()
    {
        return $this->belongsToMany(Faculty::class, 'program_mentor_coach', 'program_id', 'faculty_id');
    }
    
    public function electives()
    {
        return $this->belongsToMany(Elective::class, 'program_elective');
    }
    
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'program_resource');
    }
    
    public function recordings()
    {
        return $this->belongsToMany(Recording::class, 'program_recording');
    }
    
    public function programFeedbacks()
    {
        return $this->hasMany(ProgramFeedback::class)->latest();
    }
}
