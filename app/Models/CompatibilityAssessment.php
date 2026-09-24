<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'adoption_application_id',

    'care_ability',
    'available_time',
    'household_compatibility',
    'living_environment',
    'pet_care_experience',
    'activity_level',

    'care_score',
    'time_score',
    'household_score',
    'environment_score',
    'experience_score',
    'activity_score',

    'total_score',
    'classification',

    'gemini_explanation',
])]
class CompatibilityAssessment extends Model
{
    /**
     * The adoption application that owns this assessment.
     */
    public function adoptionApplication(): BelongsTo
    {
        return $this->belongsTo(AdoptionApplication::class);
    }
}