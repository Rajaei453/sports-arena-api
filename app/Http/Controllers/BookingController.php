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

    public function store(Request $request)
    {
        $data = $request->validate([
            'slot_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        try {
            $booking = $this->bookingRepository->createBooking($data['slot_id'], $data['user_id']);
            return response()->json($booking, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function releaseExpired()
    {
        $this->bookingRepository->releaseExpiredBookings();
        return response()->json(['message' => 'Expired bookings released'], 200);
    }
}