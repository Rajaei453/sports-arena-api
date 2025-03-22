<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function reserveSlot(Request $request)
    {
        $validated = $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $booking = $this->bookingRepository->createBooking($validated['time_slot_id'], $validated['user_id']);
            return response()->json($booking, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function releaseExpiredBookings()
    {
        $this->bookingRepository->releaseExpiredBookings();
        return response()->json(['message' => 'Expired bookings released'], 200);
    }
}
