<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cigarette extends Model
{
    protected $fillable = [
        'type',
        'brand',
        'quantity',
        'price',
        'total_price',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }
}
