<?php

namespace Database\Seeders;

use App\Models\Pet;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Add sample pets to the database.
     */
    public function run(): void
    {
        Pet::create([
            'name' => 'Buddy',
            'type' => 'Dog',
            'sex' => 'Male',
            'age' => '2 years old',
            'status' => 'Available',
            'description' => 'Friendly, playful, and loves spending time with people.',
            'emoji' => '🐶',
        ]);


        Pet::create([
            'name' => 'Luna',
            'type' => 'Cat',
            'sex' => 'Female',
            'age' => '1 year old',
            'status' => 'Available',
            'description' => 'Calm, affectionate, and curious about her surroundings.',
            'emoji' => '🐱',
        ]);


        Pet::create([
            'name' => 'Max',
            'type' => 'Dog',
            'sex' => 'Male',
            'age' => '3 years old',
            'status' => 'Available',
            'description' => 'Gentle, loyal, and enjoys daily walks and outdoor activities.',
            'emoji' => '🐕',
        ]);


        Pet::create([
            'name' => 'Milo',
            'type' => 'Cat',
            'sex' => 'Male',
            'age' => '2 years old',
            'status' => 'Available',
            'description' => 'A quiet and friendly cat who enjoys relaxing indoors.',
            'emoji' => '🐈',
        ]);


        Pet::create([
            'name' => 'Bella',
            'type' => 'Dog',
            'sex' => 'Female',
            'age' => '1 year old',
            'status' => 'Available',
            'description' => 'Energetic, sweet, and enjoys playing with people.',
            'emoji' => '🐶',
        ]);


        Pet::create([
            'name' => 'Coco',
            'type' => 'Cat',
            'sex' => 'Female',
            'age' => '3 years old',
            'status' => 'Available',
            'description' => 'Independent but affectionate once she gets comfortable.',
            'emoji' => '🐱',
        ]);
    }
}