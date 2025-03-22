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
        $arenas = $this->arenaRepository->getAll();
        return response()->json($arenas);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $arena = $this->arenaRepository->create($data);
        return response()->json($arena, 201);
    }

    public function show($id)
    {
        $arena = $this->arenaRepository->findById($id);
        if (!$arena) {
            return response()->json(['message' => 'Arena not found'], 404);
        }
        return response()->json($arena);
    }
}