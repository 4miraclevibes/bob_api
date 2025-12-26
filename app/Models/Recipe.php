<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'recipe_name',
        'category',
        'difficulty',
        'cooking_time',
        'servings',
        'ingredients',
        'instructions',
        'tags',
        'is_favorite',
        'last_cooked_at',
        'cook_count',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
            'tags' => 'array',
            'is_favorite' => 'boolean',
            'last_cooked_at' => 'datetime',
            'cook_count' => 'integer',
            'cooking_time' => 'integer',
            'servings' => 'integer',
        ];
    }
}
