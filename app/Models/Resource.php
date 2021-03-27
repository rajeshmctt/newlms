<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Kyslik\ColumnSortable\Sortable;

class Resource extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visibility', 'format', 'type', 'name', 'description', 'file_name', 'file', 'link', 'status',
    ];
    
    public $sortable = ['id', 'visibility', 'format', 'type', 'name', 'description', 'status'];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_resource');
    }
    
    public function userResources()
    {
        return $this->hasMany(UserResource::class);
    }
}
