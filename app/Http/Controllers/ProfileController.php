<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $profile = $user->role === 'adopter'
            ? $user->adopterProfile
            : null;

        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ];

        if ($user->role === 'adopter') {
            $rules['age'] = [
                'required', 'integer', 'min:18', 'max:120',
            ];

            $rules['phone_number'] = [
                'required', 'digits:11',
            ];

            $rules['address'] = [
                'required', 'string', 'max:255',
            ];

            $rules['animal_preference'] = [
                'nullable', 'in:Cat,Kitten,Dog,Puppy,Other',
            ];

            $rules['animal_preference_other'] = [
                'required_if:animal_preference,Other',
                'nullable',
                'regex:/^[\pL\s.\'-]+$/u',
                'max:255',
            ];

            $rules['preferred_breed'] = [
                'nullable',
                'regex:/^[\pL\s\'-]+$/u',
                'max:255',
            ];

            $rules['preferred_size'] = [
                'nullable', 'in:Small,Medium,Large,Extra Large',
            ];

            $rules['preferred_age_number'] = [
                'nullable', 'integer', 'min:1',
                'required_with:preferred_age_unit',
            ];

            $rules['preferred_age_unit'] = [
                'nullable',
                'required_with:preferred_age_number',
                'in:Months,Years',
            ];

            $rules['care_ability'] = [
                'nullable', 'in:Limited,Moderate,High',
            ];

            $rules['available_time'] = [
                'nullable', 'in:Low,Moderate,High',
            ];

            $rules['household_compatibility'] = [
                'nullable',
                'in:Living alone,Adults only,Family with children',
            ];

            $rules['living_environment'] = [
                'nullable', 'in:House,Apartment,Other',
            ];

            $rules['pet_care_experience'] = [
                'nullable', 'in:None,Some,Experienced',
            ];

            $rules['activity_level'] = [
                'nullable', 'in:Low,Moderate,High',
            ];
        }

        $validated = $request->validate($rules);

        if (
            $user->role === 'adopter'
            && ! empty($validated['preferred_age_number'])
        ) {
            $number = $validated['preferred_age_number'];
            $unit = $validated['preferred_age_unit'];

            if (
                ($unit === 'Months' && $number > 11)
                || ($unit === 'Years' && $number > 30)
            ) {
                return back()
                    ->withErrors([
                        'preferred_age_number' =>
                            'Months must be 1–11 and Years must be 1–30.',
                    ])
                    ->withInput();
            }
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($user->role === 'adopter') {
            $preferredAge = null;

            if (! empty($validated['preferred_age_number'])) {
                $preferredAge =
                    $validated['preferred_age_number']
                    . ' '
                    . $validated['preferred_age_unit'];
            }

            $user->adopterProfile()->updateOrCreate(
                [],
                [
                    'age' => $validated['age'],
                    'phone_number' => $validated['phone_number'],
                    'address' => $validated['address'],

                    'animal_preference' =>
                        $validated['animal_preference'] ?? null,

                    'animal_preference_other' =>
                        ($validated['animal_preference'] ?? null) === 'Other'
                            ? $validated['animal_preference_other'] ?? null
                            : null,

                    'preferred_breed' =>
                        $validated['preferred_breed'] ?? null,

                    'preferred_size' =>
                        $validated['preferred_size'] ?? null,

                    'preferred_age' => $preferredAge,

                    'care_ability' =>
                        $validated['care_ability'] ?? null,

                    'available_time' =>
                        $validated['available_time'] ?? null,

                    'household_compatibility' =>
                        $validated['household_compatibility'] ?? null,

                    'living_environment' =>
                        $validated['living_environment'] ?? null,

                    'pet_care_experience' =>
                        $validated['pet_care_experience'] ?? null,

                    'activity_level' =>
                        $validated['activity_level'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}