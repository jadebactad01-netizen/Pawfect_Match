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

    'assessment_locked_at',
    'edit_request_status',
    'edit_request_reason',
    'edit_permission_granted',
])]
class AdopterProfile extends Model
{
    protected function casts(): array
    {
        return [
            'assessment_locked_at' => 'datetime',
            'edit_permission_granted' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}