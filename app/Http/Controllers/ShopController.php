<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Perfume::query();

        // Gender filter
        if ($gender = request('gender')) {
            $query->where('gender', $gender);
        }

        // Search
        if ($q = request('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        $perfumes = $query->latest()->paginate(12)->withQueryString();

        return view('shop.index', compact('perfumes'));
    }


    public function show(Perfume $perfume)
    {
        $perfume->load(['reviews.user']);

        $avgRating = round($perfume->reviews()->avg('rating') ?? 0, 1);
        $reviewCount = $perfume->reviews()->count();

        $myReview = null;
        if (auth()->check()) {
            $myReview = $perfume->reviews()->where('user_id', auth()->id())->first();
        }

        return view('shop.show', compact('perfume', 'avgRating', 'reviewCount', 'myReview'));
    }

}
