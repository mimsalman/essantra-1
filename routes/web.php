<?php

use Illuminate\Support\Facades\Route;

use App\Models\Perfume;
use App\Models\Order;
use App\Models\Review;

use App\Http\Controllers\ShopController;
use App\Http\Controllers\PerfumeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    // ✅ if admin logged in → go admin dashboard
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    $featured = Perfume::where('is_featured', true)
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact('featured'));

})->name('home');


/*
|--------------------------------------------------------------------------
| PUBLIC SHOP
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{perfume}', [ShopController::class, 'show'])->name('shop.show');


/*
|--------------------------------------------------------------------------
| AUTH USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo');

    // ✅ password route must be POST only (fix 405 errors)
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (USER ONLY)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // ✅ admin should not open user dashboard
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $totalOrders   = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalReviews  = Review::where('user_id', $user->id)->count();

        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalReviews',
            'recentOrders'
        ));
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | REVIEWS
    |--------------------------------------------------------------------------
    */
    Route::post('/shop/{perfume}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('/cart/add/{perfume}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Buy Now
    Route::post('/cart/buy-now/{perfume}', [CartController::class, 'buyNow'])
        ->name('cart.buyNow');


    /*
    |--------------------------------------------------------------------------
    | ORDERS / CHECKOUT
    |--------------------------------------------------------------------------
    */
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders/place', [OrderController::class, 'place'])->name('orders.place');

    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (ADMIN ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | ADMIN PERFUMES (CRUD)
        |--------------------------------------------------------------------------
        */
        Route::resource('perfumes', PerfumeController::class);

        /*
        |--------------------------------------------------------------------------
        | ADMIN USERS
        |--------------------------------------------------------------------------
        */
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        /*
        |--------------------------------------------------------------------------
        | ADMIN ORDERS
        |--------------------------------------------------------------------------
        */
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        // ✅ status actions
        Route::patch('/orders/{order}/mark-paid', [AdminOrderController::class, 'markPaid'])
            ->name('orders.markPaid');

        Route::patch('/orders/{order}/mark-completed', [AdminOrderController::class, 'markCompleted'])
            ->name('orders.markCompleted');

        Route::patch('/orders/{order}/mark-cancelled', [AdminOrderController::class, 'markCancelled'])
            ->name('orders.markCancelled');
    });
