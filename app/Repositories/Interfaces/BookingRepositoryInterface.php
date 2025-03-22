<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;

interface BookingRepositoryInterface
{
    public function createBooking(int $slotId, int $userId): Booking;
    public function releaseExpiredBookings();
}
