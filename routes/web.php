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

use App\Http\Controllers\TwoFactorSettingsController;
use App\Http\Controllers\TwoFactorChallengeController;

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
| PUBLIC SHOP (NO LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{perfume}', [ShopController::class, 'show'])->name('shop.show');


/*
|--------------------------------------------------------------------------
| 2FA ROUTES (AUTH ONLY - IMPORTANT)
| These routes MUST be accessible before OTP is verified
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 2FA settings (dashboard buttons)
    Route::post('/two-factor/enable', [TwoFactorSettingsController::class, 'enable'])->name('2fa.enable');
    Route::post('/two-factor/disable', [TwoFactorSettingsController::class, 'disable'])->name('2fa.disable');

    // 2FA challenge
    Route::get('/two-factor/challenge', [TwoFactorChallengeController::class, 'show'])->name('2fa.challenge');
    Route::post('/two-factor/send', [TwoFactorChallengeController::class, 'send'])->name('2fa.send');
    Route::post('/two-factor/verify', [TwoFactorChallengeController::class, 'verify'])->name('2fa.verify');
});


/*
|--------------------------------------------------------------------------
| AUTH USER ROUTES (OTP REQUIRED IF ENABLED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'email2fa'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');


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
    Route::post('/shop/{perfume}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


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
    Route::post('/cart/buy-now/{perfume}', [CartController::class, 'buyNow'])->name('cart.buyNow');


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
| ADMIN ROUTES (OTP REQUIRED IF ENABLED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin', 'email2fa'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin perfumes CRUD
        Route::resource('perfumes', PerfumeController::class);

        // Admin users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Admin orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        // Status actions
        Route::patch('/orders/{order}/mark-paid', [AdminOrderController::class, 'markPaid'])->name('orders.markPaid');
        Route::patch('/orders/{order}/mark-completed', [AdminOrderController::class, 'markCompleted'])->name('orders.markCompleted');
        Route::patch('/orders/{order}/mark-cancelled', [AdminOrderController::class, 'markCancelled'])->name('orders.markCancelled');

        // ✅ Admin Profile page
        Route::get('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'index'])
            ->name('profile');

        Route::post('/profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])
            ->name('profile.password');

        Route::post('/profile/2fa/enable', [\App\Http\Controllers\Admin\AdminProfileController::class, 'enable2fa'])
            ->name('profile.2fa.enable');

        Route::post('/profile/2fa/disable', [\App\Http\Controllers\Admin\AdminProfileController::class, 'disable2fa'])
            ->name('profile.2fa.disable');
    });