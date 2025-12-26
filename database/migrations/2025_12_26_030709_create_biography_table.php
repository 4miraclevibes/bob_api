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
        Schema::create('biography', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['personal_info', 'education', 'daily_story', 'preference', 'lainnya']);
            $table->string('title');
            $table->text('content');
            $table->json('tags')->nullable();
            $table->boolean('is_public')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
            
            $table->index('category');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biography');
    }
};
