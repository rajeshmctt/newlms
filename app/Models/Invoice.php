<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id', 'currency_id', 'invoice_no', 'invoice_date', 'amount', 'paid_at', 'status',
    ];
    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
