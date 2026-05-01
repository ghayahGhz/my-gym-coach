<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExercise extends Model
{
    protected $guarded = [];

    protected $casts = [
        'done'    => 'boolean',
        'weight'  => 'float',
        'done_at' => 'datetime',
    ];

    public function userProfile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    // Clamp sets to 1–99
    public function adjustSets(int $delta): void
    {
        $this->sets = max(1, min(99, $this->sets + $delta));
        $this->save();
    }

    // Clamp reps to 1–999
    public function adjustReps(int $delta): void
    {
        $this->reps = max(1, min(999, $this->reps + $delta));
        $this->save();
    }

    // Clamp weight to 0–500
    public function adjustWeight(float $delta): void
    {
        $this->weight = max(0, min(500, $this->weight + $delta));
        $this->save();
    }
}
