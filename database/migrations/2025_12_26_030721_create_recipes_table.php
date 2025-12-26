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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('recipe_name');
            $table->enum('category', ['rice', 'noodle', 'soup', 'fried', 'boiled', 'lainnya']);
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->integer('cooking_time')->nullable();
            $table->integer('servings')->nullable();
            $table->json('ingredients');
            $table->text('instructions')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamp('last_cooked_at')->nullable();
            $table->integer('cook_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('recipe_name');
            $table->index('category');
            $table->index('is_favorite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
