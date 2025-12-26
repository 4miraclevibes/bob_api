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
        Schema::create('pantry_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('ingredient_name');
            $table->enum('category', ['grain', 'spice', 'vegetable', 'meat', 'dairy', 'oil', 'sauce', 'lainnya']);
            $table->string('unit');
            $table->decimal('quantity', 10, 2);
            $table->decimal('min_quantity', 10, 2)->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('ingredient_name');
            $table->index('category');
            $table->index('is_active');
            $table->index('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pantry_ingredients');
    }
};
