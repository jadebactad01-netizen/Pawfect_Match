<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(100)
            ->create([
                'role' => 'adopter',
                'approval_status' => 'Approved',
                'rejection_reason' => null,
                'valid_id_path' => null,
            ])
            ->each(function ($user) {

                $animalPreference = fake()->randomElement([
                    'Dog',
                    'Puppy',
                    'Cat',
                    'Kitten',
                    'Other',
                ]);

                $preferredAgeUnit = fake()->randomElement([
                    'Months',
                    'Years',
                ]);

                $preferredAgeNumber = $preferredAgeUnit === 'Months'
                    ? fake()->numberBetween(1, 11)
                    : fake()->numberBetween(1, 10);

                $user->adopterProfile()->create([
                    // Personal information.
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
                        'Bayambang, Pangasinan',
                    ]),

                    // Animal preferences.
                    'animal_preference' => $animalPreference,

                    'animal_preference_other' =>
                        $animalPreference === 'Other'
                            ? 'Any companion animal'
                            : null,

                    'preferred_breed' => fake()->randomElement([
                        'Aspin',
                        'Puspin',
                        'Labrador',
                        'Shih Tzu',
                        'Persian',
                        'Beagle',
                        null,
                    ]),

                    'preferred_size' => fake()->randomElement([
                        'Small',
                        'Medium',
                        'Large',
                        'Extra Large',
                    ]),

                    'preferred_age' =>
                        $preferredAgeNumber . ' ' . $preferredAgeUnit,

                    // Compatibility assessment answers.
                    'care_ability' => fake()->randomElement([
                        'Limited',
                        'Moderate',
                        'High',
                    ]),

                    'available_time' => fake()->randomElement([
                        'Low',
                        'Moderate',
                        'High',
                    ]),

                    'household_compatibility' =>
                        fake()->randomElement([
                            'Living alone',
                            'Adults only',
                            'Family with children',
                        ]),

                    'living_environment' => fake()->randomElement([
                        'House',
                        'Apartment',
                        'Condominium',
                        'Townhouse',
                        'Boarding House / Shared Housing',
                    ]),

                    'pet_care_experience' => fake()->randomElement([
                        'None',
                        'Some',
                        'Experienced',
                    ]),

                    'activity_level' => fake()->randomElement([
                        'Low',
                        'Moderate',
                        'High',
                    ]),

                    // Assessment completed and locked.
                    'assessment_locked_at' => now(),

                    // No pending edit requests.
                    'edit_request_status' => null,
                    'edit_request_reason' => null,
                    'edit_permission_granted' => false,
                ]);
            });

        Pet::factory()
            ->count(125)
            ->state(function () {

                // Generate an intake date in the past.
                $intakeDate = now()->subDays(
                    fake()->numberBetween(60, 720)
                );

                // Some pets have vaccination records.
                $isVaccinated = fake()->boolean(75);

                $vaccinationDate = $isVaccinated
                    ? $intakeDate->copy()->addDays(
                        fake()->numberBetween(1, 45)
                    )
                    : null;

                return [
                    // Pet intake information.
                    'intake_type' => fake()->randomElement([
                        'Rescued',
                        'Surrendered',
                    ]),

                    'intake_date' => $intakeDate,

                    // Vaccination information.
                    'vaccination_type' => $isVaccinated
                        ? fake()->randomElement([
                            'Anti-Rabies',
                            '5-in-1 Vaccine',
                            '6-in-1 Vaccine',
                            'Core Vaccine',
                        ])
                        : null,

                    'vaccination_date' => $vaccinationDate,

                    // Pet compatibility requirements.
                    'care_requirement' => fake()->randomElement([
                        'Low',
                        'Moderate',
                        'High',
                    ]),

                    'time_requirement' => fake()->randomElement([
                        'Low',
                        'Moderate',
                        'High',
                    ]),

                    'household_compatibility' =>
                        fake()->randomElement([
                            'Living alone',
                            'Adults only',
                            'Family with children',
                            'Any',
                        ]),

                    'living_environment' => fake()->randomElement([
                        'House',
                        'Apartment',
                        'Condominium',
                        'Townhouse',
                        'Boarding House / Shared Housing',
                        'Any',
                    ]),

                    'experience_requirement' => fake()->randomElement([
                        'None',
                        'Some',
                        'Experienced',
                    ]),

                    'activity_level' => fake()->randomElement([
                        'Low',
                        'Moderate',
                        'High',
                    ]),
                ];
            })
            ->create();
    }
}
