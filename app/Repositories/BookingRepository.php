<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookingRepository implements BookingRepositoryInterface
{
    public function createBooking(int $slotId, int $userId): Booking
    {
        return DB::transaction(function () use ($slotId, $userId) {
            $slot = TimeSlot::where('id', $slotId)->lockForUpdate()->first();

            if ($slot->is_reserved) {
                throw new \Exception('Time slot already reserved.');
            }

            $slot->update(['is_reserved' => true]);

            return Booking::create([
                'time_slot_id' => $slotId,
                'user_id' => $userId,
                'expires_at' => now()->addMinutes(10),
            ]);
        });
    }

    public function releaseExpiredBookings()
    {
        Booking::where('is_confirmed', false)
            ->where('expires_at', '<', now())
            ->delete();

        TimeSlot::whereHas('booking', function ($query) {
            $query->where('is_confirmed', false)->where('expires_at', '<', now());
        })->update(['is_reserved' => false]);
    }
}
