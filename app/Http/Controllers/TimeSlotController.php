<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;

class TimeSlotController extends Controller
{
    public function getAvailableSlots($arenaId)
    {
        return response()->json(
            TimeSlot::where('arena_id', $arenaId)->where('is_reserved', false)->get(),
            200
        );
    }

    private function requireAuth()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }
        return null;
    }

    public function store(Request $request)
    {
        if ($authResponse = $this->requireAuth()) return $authResponse;

        if ($request->user()->role !== 'owner') {
            return response()->json(['message' => 'Access denied. Only owners can create time slots.'], 403);
        }

        $validated = $request->validate([
            'arena_id' => 'required|exists:arenas,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:30|max:180',
        ]);

        $timeSlot = TimeSlot::create($validated);
        return response()->json($timeSlot, 201);
    }
}
