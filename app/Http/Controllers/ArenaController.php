<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arena;

class ArenaController extends Controller
{
    public function index()
    {
        return response()->json(Arena::all(), 200);
    }

    public function show($id)
    {
        $arena = Arena::find($id);
        return $arena ? response()->json($arena, 200) : response()->json(['error' => 'Arena not found'], 404);
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
            return response()->json(['message' => 'Access denied. Only owners can create arenas.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $arena = Arena::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'owner_id' => $request->user()->id,
        ]);

        return response()->json($arena, 201);
    }
}
