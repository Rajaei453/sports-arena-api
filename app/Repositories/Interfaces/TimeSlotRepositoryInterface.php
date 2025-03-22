<?php

namespace App\Repositories\Interfaces;

use App\Models\TimeSlot;

interface TimeSlotRepositoryInterface
{
    public function findAvailableSlots(int $arenaId);
    public function reserveSlot(int $slotId, int $userId);
}
