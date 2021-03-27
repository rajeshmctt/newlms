<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'popular', 'sort_order', 'status',
    ];
    
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
