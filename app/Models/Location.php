<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'name', 'popular', 'sort_order', 'status',
    ];
        
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
    
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
    
    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
