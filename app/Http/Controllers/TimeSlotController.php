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

    public function index($arenaId)
    {
        $slots = $this->timeSlotRepository->findAvailableSlots($arenaId);
        return response()->json($slots);
    }

    public function reserve(Request $request)
    {
        $data = $request->validate([
            'slot_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        try {
            $this->timeSlotRepository->reserveSlot($data['slot_id'], $data['user_id']);
            return response()->json(['message' => 'Slot reserved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}