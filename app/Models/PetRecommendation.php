<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetRecommendation extends Model
{
    protected $fillable = [
        'compatibility_assessment_id',
        'pet_id',
        'compatibility_score',
        'classification',
        'gemini_explanation',
    ];

    public function compatibilityAssessment(): BelongsTo
    {
        return $this->belongsTo(
            CompatibilityAssessment::class
        );
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}