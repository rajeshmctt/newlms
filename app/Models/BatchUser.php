<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Kyslik\ColumnSortable\Sortable;

class BatchUser extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batch_id', 'parent_batch_id', 'user_id', 'accept_agreement', 'certificate', 'status',
    ];

    public $sortable = ['id', 'accept_agreement', 'certificate'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function parentBatch()
    {
        return $this->belongsTo(Batch::class, 'parent_batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
