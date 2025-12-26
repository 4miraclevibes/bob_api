<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantryIngredient extends Model
{
    protected $fillable = [
        'ingredient_name',
        'category',
        'unit',
        'quantity',
        'min_quantity',
        'expiry_date',
        'purchase_date',
        'purchase_price',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'min_quantity' => 'decimal:2',
            'purchase_price' => 'decimal:2',
            'expiry_date' => 'date',
            'purchase_date' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
