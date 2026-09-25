<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;
use App\Services\CompatibilityService;

class AdoptionApplicationController extends Controller
{

    /**
     * Show the logged-in adopter's applications.
     */
    public function index(
        Request $request,
        CompatibilityService $compatibilityService
        )
    {
        $user = $request->user();

        if ($user->role !== 'adopter') {
            abort(403);
        }

        $applications = $user->adoptionApplications()
            ->with([
                'pet',
                'compatibilityAssessment',
            ])
            ->latest()
            ->get();

        // Find other compatible pets for completed assessments.
        foreach ($applications as $application) {

            if ($application->compatibilityAssessment) {

                $application->recommended_pets =
                    $compatibilityService->recommendPets(
                        $application->compatibilityAssessment,
                        $application->pet
                    );

            } else {

                $application->recommended_pets = collect();

            }
        }

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
                ->with('error', 'This pet is currently unavailable for adoption.');
        }

        // The adopter must complete their profile first.
        if (! $user->adopterProfile) {
            return redirect()
                ->route('profile.edit')
                ->with('error', 'Please complete your adopter profile before applying.');
        }

        $existingApplication = $user->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingApplication) {

            // The application exists, but the assessment
            // has not been completed yet.
            if (! $existingApplication->compatibilityAssessment) {
                return redirect()
                    ->route(
                        'compatibility-assessments.create',
                        $existingApplication
                    );
            }

            // The entire application process is already complete.
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You have already applied for this pet.'
                );
        }

        return view('adoption-applications.create', compact('pet'));
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
            'age' => ['required', 'integer', 'min:18', 'max:120'],

            'home_phone' => ['nullable', 'string', 'max:30'],
            'work_phone' => ['nullable', 'string', 'max:30'],
            'mobile_number' => ['required', 'string', 'max:30'],

            'reference_name' => ['required', 'string', 'max:255'],
            'reference_relationship' => ['required', 'string', 'max:255'],
            'reference_phone' => ['required', 'string', 'max:30'],

            'shelter_source' => [
                'required',
                'in:Friends,Print Ads,TV Show,Website,Other',
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

            'preferred_breed' => ['nullable', 'string', 'max:255'],

            'preferred_size' => [
                'nullable',
                'in:S,M,L,XL',
            ],

            'preferred_age' => ['nullable', 'string', 'max:255'],
        ]);

        // Require the "Other" description when Other is selected.
        if (
            $validated['shelter_source'] === 'Other' &&
            empty($validated['shelter_source_other'])
        ) {
            return back()
                ->withErrors([
                    'shelter_source_other' =>
                        'Please tell us how you heard about the shelter.',
                ])
                ->withInput();
        }

        if (
            $validated['animal_preference'] === 'Other' &&
            empty($validated['animal_preference_other'])
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

        return redirect()
            ->route('compatibility-assessments.create', $application);
            }
}