<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    private function requireAuth()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }
        return null;
    }

    public function reserveSlot(Request $request)
    {
        if ($authResponse = $this->requireAuth()) return $authResponse;

        if ($request->user()->role !== 'customer') {
            return response()->json(['message' => 'Access denied. Only customers can reserve slots.'], 403);
        }

        $validated = $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
        ]);

        $booking = Booking::create([
            'time_slot_id' => $validated['time_slot_id'],
            'user_id' => $request->user()->id,
            'expires_at' => now()->addMinutes(10),
        ]);

        return response()->json($booking, 201);
    }

    public function releaseExpiredBookings(Request $request) 
{
    if ($authResponse = $this->requireAuth()) return $authResponse;

    if ($request->user()->role !== 'owner') {
        return response()->json(['message' => 'Access denied. Only owners can release expired bookings.'], 403);
    }

    Booking::where('is_confirmed', false)
        ->where('expires_at', '<', now())
        ->delete();

    return response()->json(['message' => 'Expired bookings released'], 200);
}

}
