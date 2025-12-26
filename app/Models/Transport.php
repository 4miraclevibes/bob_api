<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table = 'transport';

    protected $fillable = [
        'type',
        'vehicle_type',
        'amount',
        'description',
        'service_items',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'service_items' => 'array',
        ];
    }
}
