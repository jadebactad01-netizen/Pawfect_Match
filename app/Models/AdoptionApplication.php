<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'pet_id',
    'status',
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