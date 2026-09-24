<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'pet_id',
    'status',

    'age',
    'home_phone',
    'work_phone',
    'mobile_number',

    'reference_name',
    'reference_relationship',
    'reference_phone',

    'shelter_source',
    'shelter_source_other',

    'animal_preference',
    'animal_preference_other',
    'preferred_breed',
    'preferred_size',
    'preferred_age',

    'evaluator_notes',
])]
class AdoptionApplication extends Model
{
    /**
     * The adopter who submitted this application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The pet being applied for.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}