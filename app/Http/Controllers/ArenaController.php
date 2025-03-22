<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ArenaRepositoryInterface;
use Illuminate\Http\Request;

class ArenaController extends Controller
{
    protected $arenaRepository;

    public function __construct(ArenaRepositoryInterface $arenaRepository)
    {
        $this->arenaRepository = $arenaRepository;
    }

    public function index()
    {
        return response()->json($this->arenaRepository->getAll(), 200);
    }

    public function show($id)
    {
        $arena = $this->arenaRepository->findById($id);
        return $arena ? response()->json($arena, 200) : response()->json(['error' => 'Arena not found'], 404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
        ]);

        $arena = $this->arenaRepository->create($validated);
        return response()->json($arena, 201);
    }
}
