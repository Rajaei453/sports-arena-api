<?php

use App\Http\Controllers\ArenaController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Arena Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/arenas', [ArenaController::class, 'index']);
    Route::post('/arenas', [ArenaController::class, 'store']);
    Route::get('/arenas/{id}', [ArenaController::class, 'show']);
});

// Time Slot Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/arenas/{arenaId}/slots', [TimeSlotController::class, 'index']);
    Route::post('/slots/reserve', [TimeSlotController::class, 'reserve']);
});

// Booking Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/bookings/release-expired', [BookingController::class, 'releaseExpired']);
});