<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\BookingController;

Route::prefix('arenas')->group(function () {
    Route::get('/', [ArenaController::class, 'index']); // Get all arenas
    Route::get('/{id}', [ArenaController::class, 'show']); // Get a single arena
    Route::post('/', [ArenaController::class, 'store']); // Create an arena
});

Route::prefix('time-slots')->group(function () {
    Route::get('/available/{arenaId}', [TimeSlotController::class, 'getAvailableSlots']); // Get available slots
    Route::post('/', [TimeSlotController::class, 'store']); // Create a time slot
});

Route::prefix('bookings')->group(function () {
    Route::post('/reserve', [BookingController::class, 'reserveSlot']); // Reserve a slot
    Route::post('/release-expired', [BookingController::class, 'releaseExpiredBookings']); // Release expired bookings
});
