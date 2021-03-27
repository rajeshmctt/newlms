<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserResource extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'resource_id', 'batch_id', 'status',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
