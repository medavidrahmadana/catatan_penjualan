<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_code',
        'sale_id',
        'payment_date',
        'amount'
    ];

    protected $casts = [
        'payment_date' => 'date'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
