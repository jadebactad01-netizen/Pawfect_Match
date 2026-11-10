<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition(): array
    {
        $type = fake()->randomElement([
            'Dog',
            'Cat',
        ]);

        $ageUnit = fake()->randomElement([
            'Months',
            'Years',
        ]);

        $ageNumber = $ageUnit === 'Months'
            ? fake()->numberBetween(1, 11)
            : fake()->numberBetween(1, 15);

        // Match the date of birth to the generated age.
        // Some pets have an unknown date of birth.
        $dateOfBirth = null;

        if (fake()->boolean(75)) {
            $dateOfBirth = $ageUnit === 'Months'
                ? now()->subMonths($ageNumber)->toDateString()
                : now()->subYears($ageNumber)->toDateString();
        }

        // Use appropriate breeds for dogs and cats.
        $breeds = $type === 'Dog'
            ? [
                'Aspin',
                'Labrador Retriever',
                'Shih Tzu',
                'Golden Retriever',
                'Beagle',
                'Mixed Breed',
            ]
            : [
                'Puspin',
                'Persian',
                'Siamese',
                'British Shorthair',
                'Mixed Breed',
            ];

        $colors = [
            'Black',
            'White',
            'Brown',
            'Gray',
            'Black and White',
            'Brown and White',
            'Orange',
        ];

        // Some pets have no recorded vaccination.
        $isVaccinated = fake()->boolean(70);

        return [
            // Basic information.
            'name' => fake()->firstName(),

            'type' => $type,

            'sex' => fake()->randomElement([
                'Male',
                'Female',
            ]),

            'age' => $ageNumber . ' ' . $ageUnit,

            'date_of_birth' => $dateOfBirth,

            // New pet characteristics.
            'breed' => fake()->randomElement($breeds),

            'color' => fake()->randomElement($colors),

            'size' => fake()->randomElement([
                'Small',
                'Medium',
                'Large',
            ]),

            'status' => 'Available',

            'description' => fake()->randomElement([
                'Friendly and playful.',
                'Calm and affectionate.',
                'Energetic and loves attention.',
                'Gentle and easygoing.',
                'Curious and playful.',
                'Sweet and enjoys being around people.',
                'Active and friendly.',
                'Quiet and affectionate.',
            ]),

            'photo' => null,

            // Shelter intake records.
            'intake_type' => fake()->randomElement([
                'Rescued',
                'Surrendered',
            ]),

            'intake_date' => now()
                ->subDays(fake()->numberBetween(1, 90))
                ->toDateString(),

            // Vaccination information.
            'vaccination_type' => $isVaccinated
                ? 'Anti-Rabies'
                : null,

            'vaccination_date' => $isVaccinated
                ? now()
                    ->subDays(fake()->numberBetween(1, 90))
                    ->toDateString()
                : null,

            // Compatibility requirements.
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

            'household_compatibility' => fake()->randomElement([
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
    }
}
