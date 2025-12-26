<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalSchedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'schedule_date',
        'start_time',
        'end_time',
        'location',
        'activity_type',
        'is_all_day',
        'reminder_before',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'schedule_date' => 'date',
            'is_all_day' => 'boolean',
            'reminder_before' => 'integer',
        ];
    }
}
