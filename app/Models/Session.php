<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batch_id', 'type', 'session_no', 'description', 'date', 'start_time', 'end_time', 'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
        'start_time' => 'date:H:i A',
        'end_time' => 'date:H:i A',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function recordings()
    {
        return $this->belongsToMany(Recording::class, 'session_recording');
    }
}
