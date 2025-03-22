<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Arena;
use App\Models\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimeSlotTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_time_slot()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $arena = Arena::factory()->create(['owner_id' => $owner->id]);
        $token = $owner->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/time-slots', [
            'arena_id' => $arena->id,
            'start_time' => '10:00',
            'end_time' => '11:00',
            'duration' => 60
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'arena_id', 'start_time', 'end_time']);
    }

    public function test_customer_cannot_create_time_slot()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = $customer->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/time-slots', [
            'arena_id' => 1,
            'start_time' => '10:00',
            'end_time' => '11:00',
            'duration' => 60
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(403);
    }
}
