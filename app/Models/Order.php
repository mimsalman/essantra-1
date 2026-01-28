<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id','total','status',
    'full_name','phone','address_line1','address_line2','city','postal_code',
    'payment_method','card_name','card_last4'
    ];

    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
