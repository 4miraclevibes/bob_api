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
        Schema::create('personal_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('schedule_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->enum('activity_type', ['minisoccer', 'futsal', 'nongkrong', 'belanja', 'lainnya']);
            $table->boolean('is_all_day')->default(false);
            $table->integer('reminder_before')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled']);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('schedule_date');
            $table->index('start_time');
            $table->index('status');
            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_schedules');
    }
};
