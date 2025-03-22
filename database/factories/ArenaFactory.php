<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Arena;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Arena>
 */
class ArenaFactory extends Factory
{
    protected $model = Arena::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'owner_id' => User::factory()->create(['role' => 'owner'])->id, // Ensure it belongs to an owner
        ];
    }
}
