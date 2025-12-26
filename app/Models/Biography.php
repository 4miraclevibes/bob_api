<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biography extends Model
{
    protected $table = 'biography';

    protected $fillable = [
        'category',
        'title',
        'content',
        'tags',
        'is_public',
        'priority',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_public' => 'boolean',
            'priority' => 'integer',
        ];
    }
}
