<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// ✅ Public route
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/bookings/{id}/cancel', [BookingApiController::class, 'cancel']);

// ✅ Protected routes - only accessible with Sanctum token
Route::middleware('auth:sanctum')->group(function () {

    // 1. List upcoming events (with optional search)
    Route::get('/events', [EventApiController::class, 'index']);

    // 2. Book event
    Route::post('/events/{id}/book', [BookingApiController::class, 'store']);

    // 3. View user bookings
    Route::get('/my-bookings', [BookingApiController::class, 'myBookings']);

    Route::delete('/bookings/{id}/cancel', [BookingApiController::class, 'cancel']);

   

    // 4. Get logged-in user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});