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

        return [
            'name' => fake()->firstName(),

            'type' => $type,

            'sex' => fake()->randomElement([
                'Male',
                'Female',
            ]),

            'age' => $ageNumber . ' ' . $ageUnit,

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
                'Other',
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