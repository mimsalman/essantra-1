<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfumeController;
use App\Http\Controllers\ShopController;
use App\Models\Perfume;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    $featured = Perfume::where('is_featured', true)
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact('featured'));
})->name('home');


// ✅ Public shop routes (controller)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{perfume}', [ShopController::class, 'show'])->name('shop.show');

// ✅ Admin CRUD routes (protected)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('perfumes', PerfumeController::class);
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/shop/{perfume}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

