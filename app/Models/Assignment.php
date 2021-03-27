<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'name', 'batch_id', 'due_date', 'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'date:Y-m-d',
    ];
    
    public function assignmentDocuments()
    {
        return $this->hasMany(AssignmentDocument::class);
    }
    
    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }
    
    public function userAssignment()
    {
        return $this->hasOne(UserAssignment::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
