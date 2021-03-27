<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'currency_id', 'payment_uid', 'payment_mode', 'for', 'program_id', 'batch_id', 'amount', 'description', 'pg_response', 'pg_payment_status', 'status',
    ];
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    
    public function elective()
    {
        return $this->belongsTo(Elective::class);
    }
}
