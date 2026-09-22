<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'type',
    'sex',
    'age',
    'status',
    'description',
    'emoji',

    'care_requirement',
    'time_requirement',
    'household_compatibility',
    'living_environment',
    'experience_requirement',
    'activity_level',
])]
class Pet extends Model
{
    use HasFactory;

    /**
     * Adoption applications submitted for this pet.
     */
    public function adoptionApplications(): HasMany
    {
        return $this->hasMany(AdoptionApplication::class);
    }
}
