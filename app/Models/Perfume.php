<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'category', 'price', 'stock',
        'image', 'description', 'is_featured'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
