<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['time_slot_id', 'user_id', 'is_confirmed', 'expires_at'];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function reserveSlot(int $timeSlotId, int $userId)
    {
        return DB::transaction(function () use ($timeSlotId, $userId) {
            $slot = TimeSlot::where('id', $timeSlotId)->lockForUpdate()->first();

            if ($slot->is_reserved) {
                throw new \Exception('Time slot already reserved.');
            }

            $slot->update(['is_reserved' => true]);

            return self::create([
                'time_slot_id' => $timeSlotId,
                'user_id' => $userId,
                'expires_at' => now()->addMinutes(10),
            ]);
        });
    }
}
