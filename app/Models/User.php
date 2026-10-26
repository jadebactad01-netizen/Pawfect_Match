<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'valid_id_path',
    'approval_status',
])]
#[Hidden([
    'password',
    'remember_token',
    'valid_id_path',
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function adopterProfile(): HasOne
    {
        return $this->hasOne(AdopterProfile::class);
    }

    public function adoptionApplications(): HasMany
    {
        return $this->hasMany(AdoptionApplication::class);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}