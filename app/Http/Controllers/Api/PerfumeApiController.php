<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perfume;

class PerfumeApiController extends Controller
{
    // GET /api/perfumes (protected)
    public function index()
    {
        $perfumes = Perfume::latest()->paginate(10);

        return response()->json($perfumes);
    }

    // GET /api/perfumes/{id} (protected)
    public function show($id)
    {
        $perfume = Perfume::findOrFail($id);

        return response()->json([
            'perfume' => $perfume,
        ]);
    }
}