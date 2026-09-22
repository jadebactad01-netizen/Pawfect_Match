<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'phone_number',
    'address',
    'living_environment',
    'household',
    'available_time',
    'pet_care_experience',
    'activity_level',
    'care_ability',
])]
class AdopterProfile extends Model
{
    /**
     * The user who owns this adopter profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}