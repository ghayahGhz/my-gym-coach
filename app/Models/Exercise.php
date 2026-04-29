<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_time' => 'boolean',
    ];

    public function userExercises(): HasMany
    {
        return $this->hasMany(UserExercise::class);
    }

    // muscle group label in Arabic
    public static array $muscleLabels = [
        'chest'    => 'صدر',
        'back'     => 'ظهر',
        'legs'     => 'أرجل',
        'shoulder' => 'كتف',
        'abs'      => 'بطن',
        'cardio'   => 'كارديو',
        'stretch'  => 'إطالة',
    ];
}
