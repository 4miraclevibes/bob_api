<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('teams_event_id')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location')->nullable();
            $table->json('attendees')->nullable();
            $table->string('meeting_link')->nullable();
            $table->boolean('is_all_day')->default(false);
            $table->json('recurrence')->nullable();
            $table->enum('status', ['confirmed', 'tentative', 'cancelled']);
            $table->timestamp('last_synced_at');
            $table->timestamps();
            
            $table->index('teams_event_id');
            $table->index('start_time');
            $table->index('end_time');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams_schedules');
    }
};
