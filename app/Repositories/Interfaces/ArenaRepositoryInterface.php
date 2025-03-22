<?php

namespace App\Repositories\Interfaces;

use App\Models\Arena;

interface ArenaRepositoryInterface
{
    public function getAll();
    public function findById(int $id): ?Arena;
    public function create(array $data): Arena;
}
