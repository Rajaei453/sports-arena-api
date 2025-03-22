<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TimeSlotRepositoryInterface;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    protected $timeSlotRepository;

    public function __construct(TimeSlotRepositoryInterface $timeSlotRepository)
    {
        $this->timeSlotRepository = $timeSlotRepository;
    }

    public function getAvailableSlots($arenaId)
    {
        return response()->json($this->timeSlotRepository->findAvailableSlots($arenaId), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'arena_id' => 'required|exists:arenas,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:30|max:180',
        ]);

        $timeSlot = $this->timeSlotRepository->create($validated);
        return response()->json($timeSlot, 201);
    }
}
