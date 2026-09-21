<?php

namespace App\Models;

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
])]
class Pet extends Model
{
    use HasFactory;
}
