<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TimeSlot;
use App\Models\Arena;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    protected $model = TimeSlot::class;

    public function definition(): array
    {
        return [
            'arena_id' => Arena::factory()->create()->id,
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i', '+1 hours'),
            'duration' => 60, 
            'is_reserved' => false
        ];
    }
}
