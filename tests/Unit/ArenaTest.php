<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Arena;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArenaTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_arena()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $token = $owner->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/arenas', [
            'name' => 'Elite Sports Club',
            'description' => 'Luxury sports complex'
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'name', 'description', 'owner_id']);
    }

    public function test_customer_cannot_create_arena()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = $customer->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/arenas', [
            'name' => 'Customer Arena'
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(403);
    }
}
