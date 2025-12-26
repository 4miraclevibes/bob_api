<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationState extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'status',
        'last_activity',
        'current_location',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
        ];
    }

    public function touch($attribute = null): bool
    {
        $this->updated_at = now();
        return $this->save();
    }
}
