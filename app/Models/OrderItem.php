<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'discogs_id',
        'name',
        'artist',
        'price',
        'quantity',
        'cover_url',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
