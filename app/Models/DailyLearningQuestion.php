<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyLearningQuestion extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'difficulty',
        'tags',
        'keywords',
        'given_date',
        'discussed_at',
        'is_answered',
        'source',
        'related_resources',
        'content_shared',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'keywords' => 'array',
            'related_resources' => 'array',
            'given_date' => 'date',
            'discussed_at' => 'datetime',
            'is_answered' => 'boolean',
            'content_shared' => 'boolean',
        ];
    }
}
