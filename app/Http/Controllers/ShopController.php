<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $perfumes = Perfume::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('brand', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%");
            })
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.index', compact('perfumes', 'q'));
    }

    public function show(Perfume $perfume)
    {
        $perfume->load(['reviews' => function ($q) {
            $q->latest();
        }, 'reviews.user']);

        $avgRating = $perfume->reviews()->avg('rating');
        $avgRating = $avgRating ? round($avgRating, 1) : null;

        return view('shop.show', compact('perfume', 'avgRating'));
    }
}
