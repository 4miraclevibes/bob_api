<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamsSchedule extends Model
{









    protected $fillable = [
        'teams_event_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'attendees',
        'meeting_link',
        'is_all_day',
        'recurrence',
        'status',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'last_synced_at' => 'datetime',
            'attendees' => 'array',
            'recurrence' => 'array',
            'is_all_day' => 'boolean',
        ];
    }
}
