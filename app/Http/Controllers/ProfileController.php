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
        $profile = $user->adopterProfile;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => [
                'nullable', 'string', 'min:8', 'confirmed',
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
            ];

            $rules['preferred_age_unit'] = [
                'nullable', 'in:Months,Years',
            ];

            // Only validate the assessment when editing is allowed.
            if (
                ! $profile?->assessment_locked_at
                || $profile?->edit_permission_granted
            ) {
                $rules['care_ability'] = [
                    'required', 'in:Limited,Moderate,High',
                ];

                $rules['available_time'] = [
                    'required', 'in:Low,Moderate,High',
                ];

                $rules['household_compatibility'] = [
                    'required',
                    'in:Living alone,Adults only,Family with children',
                ];

                $rules['living_environment'] = [
                    'required', 'in:House,Apartment,Other',
                ];

                $rules['pet_care_experience'] = [
                    'required', 'in:None,Some,Experienced',
                ];

                $rules['activity_level'] = [
                    'required', 'in:Low,Moderate,High',
                ];
            }
        }

        $validated = $request->validate($rules);

        if ($user->role === 'adopter') {
            $number = $validated['preferred_age_number'] ?? null;
            $unit = $validated['preferred_age_unit'] ?? null;

            if (
                ($number && ! $unit)
                || ($number && $unit === 'Months' && $number > 11)
                || ($number && $unit === 'Years' && $number > 30)
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

            $data = [
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
            ];

            if (
                ! $profile?->assessment_locked_at
                || $profile?->edit_permission_granted
            ) {
                $data['care_ability'] =
                    $validated['care_ability'];

                $data['available_time'] =
                    $validated['available_time'];

                $data['household_compatibility'] =
                    $validated['household_compatibility'];

                $data['living_environment'] =
                    $validated['living_environment'];

                $data['pet_care_experience'] =
                    $validated['pet_care_experience'];

                $data['activity_level'] =
                    $validated['activity_level'];

                // Saving consumes the one-time editing permission.
                $data['assessment_locked_at'] = now();
                $data['edit_permission_granted'] = false;

                if ($profile?->edit_permission_granted) {
                    $data['edit_request_status'] = 'Completed';
                }
            }

            $user->adopterProfile()->updateOrCreate([], $data);
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    public function requestEdit(Request $request)
    {
        if ($request->user()->role !== 'adopter') {
            abort(403);
        }

        $profile = $request->user()->adopterProfile;

        if (! $profile || ! $profile->assessment_locked_at) {
            return back()->with(
                'error',
                'Complete your assessment first.'
            );
        }

        if (
            $profile->edit_request_status === 'Pending'
            || $profile->edit_permission_granted
        ) {
            return back()->with(
                'error',
                'You already have a pending request or permission to edit.'
            );
        }

        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $profile->update([
            'edit_request_reason' => $validated['reason'],
            'edit_request_status' => 'Pending',
            'edit_permission_granted' => false,
        ]);

        return back()->with(
            'success',
            'Your request was submitted for administrator review.'
        );
    }
}