<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;

class AdoptionApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        $applications = $user->adoptionApplications()
            ->with([
                'pet',
                'compatibilityAssessment.petRecommendations.pet',
            ])
            ->latest()
            ->get();

        return view(
            'adoption-applications.index',
            compact('applications')
        );
    }

    public function create(Request $request, Pet $pet)
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        if ($pet->status !== 'Available') {
            return redirect()
                ->route('pets.show', $pet)
                ->with('error', 'This pet is currently unavailable for adoption.');
        }

        $profile = $user->adopterProfile;

        if (
            ! $profile
            || ! $profile->age
            || ! $profile->phone_number
            || ! $profile->address
            || ! $profile->animal_preference
            || ! $profile->assessment_locked_at
        ) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your adopter profile, animal preferences and compatibility assessment before applying.'
                );
        }

        $existingApplication = $user->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingApplication) {
            if (! $existingApplication->compatibilityAssessment) {
                return redirect()
                    ->route('compatibility-assessments.create', $existingApplication);
            }

            return redirect()
                ->route('adoption-applications.index')
                ->with('error', 'You have already applied for this pet.');
        }

        return view('adoption-applications.create', compact('pet'));
    }

    public function store(Request $request, Pet $pet)
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        if ($pet->status !== 'Available') {
            return redirect()
                ->route('pets.show', $pet)
                ->with('error', 'This pet is currently unavailable for adoption.');
        }

        $profile = $user->adopterProfile;

        if (
            ! $profile
            || ! $profile->age
            || ! $profile->phone_number
            || ! $profile->address
            || ! $profile->animal_preference
            || ! $profile->assessment_locked_at
        ) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your profile and assessment before applying.'
                );
        }

        $existingApplication = $user->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingApplication) {
            if (! $existingApplication->compatibilityAssessment) {
                return redirect()
                    ->route('compatibility-assessments.create', $existingApplication);
            }

            return redirect()
                ->route('pets.show', $pet)
                ->with('error', 'You have already applied for this pet.');
        }

        // Only validate the fields the adopter can actually edit.
        $validated = $request->validate([
            'reference_name' => [
                'required',
                'regex:/^[\pL\s.\'-]+$/u',
                'max:255',
            ],

            'reference_relationship' => [
                'required',
                'regex:/^[\pL\s.\'-]+$/u',
                'max:255',
            ],

            'reference_phone' => [
                'required', 'digits:11',
            ],

            'shelter_source' => [
                'required',
                'in:Friends,Facebook,Website,Other',
            ],

            'shelter_source_other' => [
                'required_if:shelter_source,Other',
                'nullable',
                'regex:/^[\pL\s.\'-]+$/u',
                'max:255',
            ],
        ]);

        if ($validated['shelter_source'] !== 'Other') {
            $validated['shelter_source_other'] = null;
        }

        // Copy protected information directly from the adopter profile.
        $application = AdoptionApplication::create([
            'user_id' => $user->id,
            'pet_id' => $pet->id,
            'status' => 'Pending',

            'age' => $profile->age,
            'mobile_number' => $profile->phone_number,

            'animal_preference' => $profile->animal_preference,
            'animal_preference_other' => $profile->animal_preference_other,
            'preferred_breed' => $profile->preferred_breed,
            'preferred_size' => $profile->preferred_size,
            'preferred_age' => $profile->preferred_age,

            ...$validated,
        ]);

        $pet->update([
            'status' => 'Unavailable',
        ]);

        return redirect()
            ->route('compatibility-assessments.create', $application);
    }
}