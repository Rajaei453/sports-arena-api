<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['arena_id', 'start_time', 'end_time', 'duration', 'is_reserved'];

    public function arena()
    {
        return $this->belongsTo(Arena::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_reserved', false);
    }
}
