<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PerfumeApiController;

/*
|--------------------------------------------------------------------------
| Public Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']); // POST /api/register
Route::post('/login',    [AuthController::class, 'login']);    // POST /api/login

/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']); // POST /api/logout
    Route::get('/me',      [AuthController::class, 'me']);     // GET  /api/me

    // Protected Product API (Perfumes example)
    Route::get('/perfumes',         [PerfumeApiController::class, 'index']); // GET /api/perfumes
    Route::get('/perfumes/{id}',    [PerfumeApiController::class, 'show']);  // GET /api/perfumes/1
});