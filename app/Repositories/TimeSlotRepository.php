<?php

namespace App\Repositories;

use App\Models\TimeSlot;
use App\Repositories\Interfaces\TimeSlotRepositoryInterface;

class TimeSlotRepository implements TimeSlotRepositoryInterface
{
    public function findAvailableSlots(int $arenaId)
    {
        return TimeSlot::where('arena_id', $arenaId)->where('is_reserved', false)->get();
    }

    public function reserveSlot(int $slotId, int $userId)
    {
        $slot = TimeSlot::where('id', $slotId)->lockForUpdate()->first();

        if ($slot->is_reserved) {
            throw new \Exception('Time slot already reserved.');
        }

        $slot->update(['is_reserved' => true]);
    }
}
