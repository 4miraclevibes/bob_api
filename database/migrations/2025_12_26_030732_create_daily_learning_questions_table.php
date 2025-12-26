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
        Schema::create('daily_learning_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer')->nullable();
            $table->enum('category', ['algorithm', 'data_structure', 'design_pattern', 'architecture', 'database', 'security', 'performance', 'testing', 'best_practice', 'lainnya']);
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced']);
            $table->json('tags');
            $table->json('keywords')->nullable();
            $table->date('given_date')->nullable();
            $table->timestamp('discussed_at')->nullable();
            $table->boolean('is_answered')->default(false);
            $table->string('source')->nullable();
            $table->json('related_resources')->nullable();
            $table->boolean('content_shared')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('given_date');
            $table->index('category');
            $table->index('is_answered');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_learning_questions');
    }
};
