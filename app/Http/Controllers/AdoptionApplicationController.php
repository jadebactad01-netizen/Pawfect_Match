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

        // Show Pending by default.
        $filter = $request->query('filter', 'pending');

        $allowedFilters = [
            'all',
            'pending',
            'approved',
            'rejected',
            'incomplete',
        ];

        if (!in_array($filter, $allowedFilters)) {
            $filter = 'pending';
        }

        $query = $user->adoptionApplications()
            ->with([
                'pet',
                'compatibilityAssessment.petRecommendations.pet',
            ]);

        if ($filter === 'pending') {
            $query->where('status', 'Pending')
                ->whereHas('compatibilityAssessment');

        } elseif ($filter === 'approved') {
            $query->where('status', 'Approved');

        } elseif ($filter === 'rejected') {
            $query->where('status', 'Rejected');

        } elseif ($filter === 'incomplete') {
            $query->whereDoesntHave('compatibilityAssessment');
        }

        $applications = $query
            ->latest()
            ->paginate(4)
            ->withQueryString();

        return view(
            'adoption-applications.index',
            compact('applications', 'filter')
        );
    }

    public function create(Request $request, Pet $pet)
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        $profile = $user->adopterProfile;

        if (
            !$profile
            || !$profile->age
            || !$profile->phone_number
            || !$profile->address
            || !$profile->animal_preference
            || !$profile->assessment_locked_at
        ) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your adopter profile, animal preferences and compatibility assessment before applying.'
                );
        }

        // Check whether this adopter has already applied.
        $application = $user->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($application) {

            // Allow editing only while the application is incomplete.
            if (
                $application->status === 'Pending'
                && !$application->compatibilityAssessment
            ) {
                return view(
                    'adoption-applications.create',
                    compact('pet', 'application')
                );
            }

            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You have already applied for this pet.'
                );
        }

        // Only new applications require an available pet.
        if ($pet->status !== 'Available') {
            return redirect()
                ->route('pets.show', $pet)
                ->with(
                    'error',
                    'This pet is currently unavailable for adoption.'
                );
        }

        // No existing application: display a blank form.
        $application = null;

        return view(
            'adoption-applications.create',
            compact('pet', 'application')
        );
    }

    public function store(Request $request, Pet $pet)
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        $profile = $user->adopterProfile;

        if (
            !$profile
            || !$profile->age
            || !$profile->phone_number
            || !$profile->address
            || !$profile->animal_preference
            || !$profile->assessment_locked_at
        ) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your profile and assessment before applying.'
                );
        }

        // Find this adopter's existing application.
        $application = $user->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($application) {

            // Completed or reviewed applications cannot be edited.
            if (
                $application->status !== 'Pending'
                || $application->compatibilityAssessment
            ) {
                return redirect()
                    ->route('adoption-applications.index')
                    ->with(
                        'error',
                        'You have already applied for this pet.'
                    );
            }

        } elseif ($pet->status !== 'Available') {

            // New applications require an available pet.
            return redirect()
                ->route('pets.show', $pet)
                ->with(
                    'error',
                    'This pet is currently unavailable for adoption.'
                );
        }

        // Validate only the fields the adopter can edit.
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
                'required',
                'digits:11',
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

        // Get information directly from the adopter profile.
        $data = [
            'age' => $profile->age,
            'mobile_number' => $profile->phone_number,

            'animal_preference' => $profile->animal_preference,
            'animal_preference_other' => $profile->animal_preference_other,
            'preferred_breed' => $profile->preferred_breed,
            'preferred_size' => $profile->preferred_size,
            'preferred_age' => $profile->preferred_age,

            ...$validated,
        ];

        if ($application) {

            // Reuse the existing incomplete application.
            $application->update($data);

        } else {

            // Create the application only the first time.
            $application = AdoptionApplication::create([
                'user_id' => $user->id,
                'pet_id' => $pet->id,
                'status' => 'Pending',

                ...$data,
            ]);

            // Reserve the pet for this application.
            $pet->update([
                'status' => 'Unavailable',
            ]);
        }

        // Continue to Step 2 using the same application.
        return redirect()
            ->route(
                'compatibility-assessments.create',
                $application
            );
    }
}
