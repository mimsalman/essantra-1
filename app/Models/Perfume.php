<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'price', 'stock', 'description', 'image_path', 'gender', 'is_featured'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

}

