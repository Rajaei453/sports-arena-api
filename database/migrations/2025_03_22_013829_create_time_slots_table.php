<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arena_id')->constrained('arenas')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration'); // Duration in minutes (e.g., 30, 60)
            $table->boolean('is_reserved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
