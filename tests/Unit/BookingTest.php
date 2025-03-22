<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Arena;
use App\Models\TimeSlot;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_book_time_slot()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $timeSlot = TimeSlot::factory()->create(); // ✅ Create a valid time slot
        $token = $customer->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/bookings/reserve', [
            'time_slot_id' => $timeSlot->id // ✅ Use valid ID
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'time_slot_id', 'user_id', 'expires_at']);
    }

    public function test_owner_cannot_book_time_slot()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $timeSlot = TimeSlot::factory()->create(); // ✅ Create a valid time slot
        $token = $owner->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/bookings/reserve', [
            'time_slot_id' => $timeSlot->id // ✅ Use valid ID
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(403);
    }
}
