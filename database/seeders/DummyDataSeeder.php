<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Create 60 dummy adopters.
         */
        User::factory()
            ->count(60)
            ->create([
                'role' => 'adopter',
            ])
            ->each(function ($user) {

                $user->adopterProfile()->create([
                    'age' => fake()->numberBetween(18, 60),

                    'phone_number' =>
                        '09' . fake()->numerify('#########'),

                    'address' => fake()->randomElement([
                        'Santa Barbara, Pangasinan',
                        'Urdaneta City, Pangasinan',
                        'Dagupan City, Pangasinan',
                        'Calasiao, Pangasinan',
                        'Malasiqui, Pangasinan',
                        'Mangaldan, Pangasinan',
                        'San Carlos City, Pangasinan',
                        'Villasis, Pangasinan',
                    ]),
                ]);

            });

        /*
         * Create 45 dummy pets.
         * Photos will be added manually.
         */
        Pet::factory()
            ->count(45)
            ->create();
    }
}