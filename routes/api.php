<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('check.jwt')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::get('bookings/{id}', [BookingController::class, 'show']);
    Route::put('bookings/{id}', [BookingController::class, 'update']);
    Route::delete('bookings/{id}', [BookingController::class, 'destroy']);

    Route::get('user/{userId}/bookings', [BookingController::class, 'userBookings']);
});
