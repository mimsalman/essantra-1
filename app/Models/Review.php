<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'perfume_id', 'rating', 'title', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perfume()
    {
        return $this->belongsTo(Perfume::class);
    }
}

