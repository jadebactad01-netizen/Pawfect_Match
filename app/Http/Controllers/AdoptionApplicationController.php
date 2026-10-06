<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;

class AdoptionApplicationController extends Controller
{
    /**
     * Show the logged-in adopter's applications.
     */
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


    /**
     * Show the adoption application form.
     */
    public function create(Request $request, Pet $pet)
    {
        $user = $request->user();

        // Only adopter accounts can apply.
        if ($user->role !== 'adopter') {
            abort(403);
        }

        // Only available pets can receive applications.
        if ($pet->status !== 'Available') {
            return redirect()
                ->route('pets.show', $pet)
                ->with(
                    'error',
                    'This pet is currently unavailable for adoption.'
                );
        }

        // The adopter must complete their profile first.
        if (! $user->adopterProfile) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your adopter profile before applying.'
                );
        }

        $existingApplication = $user
            ->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingApplication) {

            // Application exists but assessment is not complete.
            if (! $existingApplication->compatibilityAssessment) {
                return redirect()
                    ->route(
                        'compatibility-assessments.create',
                        $existingApplication
                    );
            }

            // Application process is already complete.
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You have already applied for this pet.'
                );
        }

        return view(
            'adoption-applications.create',
            compact('pet')
        );
    }


    /**
     * Save the adoption application.
     */
    public function store(Request $request, Pet $pet)
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        if ($pet->status !== 'Available') {
            return redirect()
                ->route('pets.show', $pet)
                ->with(
                    'error',
                    'This pet is currently unavailable for adoption.'
                );
        }

        if (! $user->adopterProfile) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your adopter profile before applying.'
                );
        }

        $existingApplication = $user
            ->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingApplication) {

            if (! $existingApplication->compatibilityAssessment) {
                return redirect()
                    ->route(
                        'compatibility-assessments.create',
                        $existingApplication
                    );
            }

            return redirect()
                ->route('pets.show', $pet)
                ->with(
                    'error',
                    'You have already applied for this pet.'
                );
        }

        $validated = $request->validate([

            'reference_name' => [
                'required',
                'string',
                'max:255',
            ],

            'reference_relationship' => [
                'required',
                'string',
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
                'nullable',
                'string',
                'max:255',
            ],

            'animal_preference' => [
                'required',
                'in:Cat,Kitten,Dog,Puppy,Other',
            ],

            'animal_preference_other' => [
                'nullable',
                'string',
                'max:255',
            ],

            'preferred_breed' => [
                'nullable',
                'regex:/^[a-zA-Z\s\-]+$/',
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

        $validated['age'] =
            $user->adopterProfile->age;

        $validated['mobile_number'] =
            $user->adopterProfile->phone_number;


        // Check preferred age in months.
        if (
            isset($validated['preferred_age_number'])
            && $validated['preferred_age_unit'] === 'Months'
            && $validated['preferred_age_number'] > 11
        ) {
            return back()
                ->withErrors([
                    'preferred_age_number' =>
                        'Age in months must be between 1 and 11.',
                ])
                ->withInput();
        }


        // Check preferred age in years.
        if (
            isset($validated['preferred_age_number'])
            && $validated['preferred_age_unit'] === 'Years'
            && $validated['preferred_age_number'] > 30
        ) {
            return back()
                ->withErrors([
                    'preferred_age_number' =>
                        'Age in years must be between 1 and 30.',
                ])
                ->withInput();
        }


        // Combine preferred age number and unit.
        if (isset($validated['preferred_age_number'])) {

            $validated['preferred_age'] =
                $validated['preferred_age_number']
                . ' '
                . $validated['preferred_age_unit'];
        }

        unset(
            $validated['preferred_age_number'],
            $validated['preferred_age_unit']
        );


        // Require description when Other is selected.
        if (
            $validated['shelter_source'] === 'Other'
            && empty($validated['shelter_source_other'])
        ) {
            return back()
                ->withErrors([
                    'shelter_source_other' =>
                        'Please tell us how you heard about the shelter.',
                ])
                ->withInput();
        }


        // Require animal description when Other is selected.
        if (
            $validated['animal_preference'] === 'Other'
            && empty($validated['animal_preference_other'])
        ) {
            return back()
                ->withErrors([
                    'animal_preference_other' =>
                        'Please specify your animal preference.',
                ])
                ->withInput();
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
            ->route(
                'compatibility-assessments.create',
                $application
            );
    }
}