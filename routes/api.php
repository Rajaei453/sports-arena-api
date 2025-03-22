<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\BookingController;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Arena Management (Only for Owners)
Route::prefix('arenas')->group(function () {
    Route::get('/', [ArenaController::class, 'index']);
    Route::get('/{id}', [ArenaController::class, 'show']);
    Route::post('/', [ArenaController::class, 'store'])->middleware('auth:sanctum'); // Only owners can create arenas
});

// Time Slots (Only for Owners)
Route::prefix('time-slots')->group(function () {
    Route::get('/available/{arenaId}', [TimeSlotController::class, 'getAvailableSlots']);
    Route::post('/', [TimeSlotController::class, 'store'])->middleware('auth:sanctum'); // Only owners can create time slots
});

// Booking (Only for Customers)
Route::prefix('bookings')->group(function () {
    Route::post('/reserve', [BookingController::class, 'reserveSlot'])->middleware('auth:sanctum'); // Only customers can book slots
    Route::post('/release-expired', [BookingController::class, 'releaseExpiredBookings'])->middleware('auth:sanctum'); // Only owners can release expired bookings
});
