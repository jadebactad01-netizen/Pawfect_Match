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

        if (! $user->adopterProfile) {
            return redirect()
                ->route('profile.edit')
                ->with('error', 'Please complete your adopter profile before applying.');
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

        if (! $user->adopterProfile) {
            return redirect()
                ->route('profile.edit')
                ->with('error', 'Please complete your adopter profile before applying.');
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

            'animal_preference' => [
                'required',
                'in:Cat,Kitten,Dog,Puppy,Other',
            ],

            'animal_preference_other' => [
                'required_if:animal_preference,Other',
                'nullable',
                'regex:/^[\pL\s.\'-]+$/u',
                'max:255',
            ],

            'preferred_breed' => [
                'nullable',
                'regex:/^[\pL\s\'-]+$/u',
                'max:255',
            ],

            'preferred_size' => [
                'nullable',
                'in:Small,Medium,Large,Extra Large',
            ],

            'preferred_age_number' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'preferred_age_unit' => [
                'nullable',
                'in:Months,Years',
            ],
        ]);

        $validated['age'] = $user->adopterProfile->age;
        $validated['mobile_number'] = $user->adopterProfile->phone_number;

        if (isset($validated['preferred_age_number'])) {
            $number = $validated['preferred_age_number'];
            $unit = $validated['preferred_age_unit'] ?? null;

            if (
                ! $unit
                || ($unit === 'Months' && $number > 11)
                || ($unit === 'Years' && $number > 30)
            ) {
                return back()
                    ->withErrors([
                        'preferred_age_number' =>
                            'Months must be 1–11 and Years must be 1–30.',
                    ])
                    ->withInput();
            }

            $validated['preferred_age'] = $number . ' ' . $unit;
        }

        unset(
            $validated['preferred_age_number'],
            $validated['preferred_age_unit']
        );

        if ($validated['shelter_source'] !== 'Other') {
            $validated['shelter_source_other'] = null;
        }

        if ($validated['animal_preference'] !== 'Other') {
            $validated['animal_preference_other'] = null;
        }

        $application = AdoptionApplication::create([
            'user_id' => $user->id,
            'pet_id' => $pet->id,
            'status' => 'Pending',
            ...$validated,
        ]);

        $pet->update([
            'status' => 'Unavailable',
        ]);

        return redirect()
            ->route('compatibility-assessments.create', $application);
    }
}