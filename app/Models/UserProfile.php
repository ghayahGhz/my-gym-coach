<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProfile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'days'      => 'array',
        'day_types' => 'array',
        'weight'    => 'float',
        'height'    => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userExercises(): HasMany
    {
        return $this->hasMany(UserExercise::class);
    }

    public function doneDates(): HasMany
    {
        return $this->hasMany(DoneDate::class);
    }

    // Returns exercises for a specific day
    public function exercisesForDay(string $day)
    {
        return $this->userExercises()
            ->where('day', $day)
            ->with('exercise')
            ->orderBy('sort_order')
            ->get();
    }

    // Count of done exercises for a day
    public function doneCountForDay(string $day): int
    {
        return $this->userExercises()
            ->where('day', $day)
            ->where('done', true)
            ->count();
    }

    // Completion ratio 0.0 – 1.0 for a day
    public function progressForDay(string $day): float
    {
        $total = $this->userExercises()->where('day', $day)->count();
        if ($total === 0) return 0.0;
        return $this->doneCountForDay($day) / $total;
    }

    // Consecutive training days streak (max 30)
    public function streak(): int
    {
        $doneDates = $this->doneDates()
            ->orderByDesc('date')
            ->pluck('date')
            ->map(fn($d) => \Carbon\Carbon::parse($d))
            ->toArray();

        if (empty($doneDates)) return 0;

        $streak  = 0;
        $current = \Carbon\Carbon::today();

        foreach ($doneDates as $date) {
            if ($date->isSameDay($current) || $date->isSameDay($current->copy()->subDay())) {
                $streak++;
                $current = $date;
                if ($streak >= 30) break;
            } else {
                break;
            }
        }

        return $streak;
    }

    // Total training minutes = total done sessions × session_dur
    public function totalMins(): int
    {
        return $this->doneDates()->count() * $this->session_dur;
    }

    // Is a given weekday (sat/sun/…) a training day?
    public function isWorkoutDay(string $day): bool
    {
        return in_array($day, $this->days ?? []);
    }

    // CSS accent color based on gender
    public function accentColor(): string
    {
        return $this->gender === 'male' ? '#E2F163' : '#896CFE';
    }

    // CSS accent2 color
    public function accent2Color(): string
    {
        return $this->gender === 'male' ? '#C8D84F' : '#B3A0FF';
    }

    // Tailwind class prefix for accent
    public function themeClass(): string
    {
        return $this->gender === 'male' ? 'theme-male' : 'theme-female';
    }
}
