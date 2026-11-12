<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        // Generate an optional date of birth.
        $dateOfBirth = null;

        if (fake()->boolean(75)) {
            $dateOfBirth = $ageUnit === 'Months'
                ? now()->subMonths($ageNumber)->toDateString()
                : now()->subYears($ageNumber)->toDateString();
        }

        // Use dog or cat breeds.
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

        $isVaccinated = fake()->boolean(70);

        return [
            // Basic pet information.
            'name' => fake()->firstName(),

            'type' => $type,

            'sex' => fake()->randomElement([
                'Male',
                'Female',
            ]),

            'age' => $ageNumber . ' ' . $ageUnit,

            'date_of_birth' => $dateOfBirth,

            // Pet characteristics.
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

            // Automatically choose a dog or cat photo.
            'photo' => $this->randomPhoto($type),

            // Shelter intake details.
            'intake_type' => fake()->randomElement([
                'Rescued',
                'Surrendered',
            ]),

            'intake_date' => now()
                ->subDays(fake()->numberBetween(1, 90))
                ->toDateString(),

            // Vaccination details.
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

    /**
     * Pick a random photo for the correct pet type.
     */
    private function randomPhoto(string $type): ?string
    {
        // Example: public/images/dogs or public/images/cats.
        $folder = $type === 'Dog'
            ? public_path('images/dogs')
            : public_path('images/cats');

        // No photos available yet.
        if (!File::isDirectory($folder)) {
            return null;
        }

        // Get supported image files only.
        $images = [];

        foreach (File::files($folder) as $file) {
            $extension = strtolower($file->getExtension());

            if (in_array($extension, [
                'jpg',
                'jpeg',
                'png',
                'webp',
            ])) {
                $images[] = $file;
            }
        }

        if (empty($images)) {
            return null;
        }

        // Pick a random image.
        $selected = fake()->randomElement($images);

        // Save its path in Laravel public storage.
        $photoPath = 'pets/demo/'
            . strtolower($type)
            . '/'
            . $selected->getFilename();

        // Copy the image once if it is not already there.
        if (!Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->put(
                $photoPath,
                File::get($selected->getPathname())
            );
        }

        return $photoPath;
    }
}
