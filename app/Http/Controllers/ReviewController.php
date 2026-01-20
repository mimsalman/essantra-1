<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Perfume $perfume)
    {
        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'title'   => ['nullable', 'string', 'max:100'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'perfume_id' => $perfume->id,
            ],
            [
                'rating' => $validated['rating'],
                'title' => $validated['title'] ?? null,
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return back()->with('success', 'Thanks! Your review was saved.');
    }
}

