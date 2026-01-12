<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'price', 'stock', 'description', 'image_path'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

