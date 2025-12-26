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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['food', 'drink', 'snack']);
            $table->string('item_name');
            $table->decimal('cost', 10, 2);
            $table->integer('quantity')->default(1);
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
