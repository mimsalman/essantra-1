<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Perfume $perfume)
    {
        $data = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'perfume_id' => $perfume->id,
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]
        );

        return back()->with('success', 'Review submitted!');
    }

    public function destroy(Review $review)
    {
        // allow owner OR admin
        if (auth()->id() !== $review->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Review deleted!');
    }
}
