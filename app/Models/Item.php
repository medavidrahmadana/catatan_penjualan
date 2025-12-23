<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'image',
        'price'
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
