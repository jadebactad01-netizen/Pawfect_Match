<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'age',
    'phone_number',
    'address',

    'animal_preference',
    'animal_preference_other',
    'preferred_breed',
    'preferred_size',
    'preferred_age',

    'care_ability',
    'available_time',
    'household_compatibility',
    'living_environment',
    'pet_care_experience',
    'activity_level',
])]
class AdopterProfile extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}