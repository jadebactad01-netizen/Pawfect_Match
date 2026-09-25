<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\CompatibilityAssessment;
use App\Services\CompatibilityService;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class CompatibilityAssessmentController extends Controller
{
    /**
     * Show the compatibility assessment.
     */
    public function create(
        Request $request,
        AdoptionApplication $application
    ) {
        // Make sure the application belongs to
        // the logged-in adopter.
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        // Prevent another assessment if one already exists.
        if ($application->compatibilityAssessment) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You already completed the compatibility assessment.'
                );
        }

        $application->load('pet');

        return view(
            'compatibility-assessments.create',
            compact('application')
        );
    }

    /**
     * Save the assessment and calculate compatibility.
     */
    public function store(
        Request $request,
        AdoptionApplication $application,
        CompatibilityService $compatibilityService,
        GeminiService $geminiService
    ) {
        // Make sure this application belongs to the adopter.
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        // Prevent duplicate assessments.
        if ($application->compatibilityAssessment) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You already completed the compatibility assessment.'
                );
        }


        $validated = $request->validate([
            'care_ability' => [
                'required',
                'in:Limited,Moderate,High',
            ],

            'available_time' => [
                'required',
                'in:Low,Moderate,High',
            ],

            'household_compatibility' => [
                'required',
                'in:Living alone,Adults only,Family with children',
            ],

            'living_environment' => [
                'required',
                'in:House,Apartment,Other',
            ],

            'pet_care_experience' => [
                'required',
                'in:None,Some,Experienced',
            ],

            'activity_level' => [
                'required',
                'in:Low,Moderate,High',
            ],
        ]);


        // First save the adopter's answers.
        $assessment = CompatibilityAssessment::create([
            'adoption_application_id' => $application->id,

            ...$validated,
        ]);


        // Load the pet being applied for.
        $application->load('pet');


        // Calculate the compatibility score.
        $result = $compatibilityService->calculate(
            $assessment,
            $application->pet
        );


        // Save the calculated result.
        $assessment->update($result);

        // Ask Gemini to explain the already-calculated result.
        $explanation = $geminiService
            ->generateCompatibilityExplanation(
                $assessment,
                $application->pet
            );


        // Save the explanation only if Gemini returned one.
        if ($explanation) {
            $assessment->update([
                'gemini_explanation' => $explanation,
            ]);
        }


        return redirect()
            ->route('adoption-applications.index')
            ->with(
                'success',
                'Your adoption application and compatibility assessment were submitted successfully.'
            );
    }

    /**
     * Retry generating the Gemini compatibility explanation.
     */
    public function retryExplanation(
        Request $request,
        AdoptionApplication $application,
        GeminiService $geminiService
    ) {
        // Make sure this application belongs to
        // the logged-in adopter.
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }


    $application->load([
        'pet',
        'compatibilityAssessment',
    ]);


    $assessment = $application->compatibilityAssessment;


    // The assessment must already be completed.
    if (! $assessment) {
        return redirect()
            ->route('adoption-applications.index')
            ->with(
                'error',
                'Complete the compatibility assessment first.'
            );
    }


    // No need to call Gemini again if an explanation exists.
    if ($assessment->gemini_explanation) {
        return redirect()
            ->route('adoption-applications.index')
            ->with(
                'success',
                'The compatibility explanation is already available.'
            );
    }


    $explanation = $geminiService
        ->generateCompatibilityExplanation(
            $assessment,
            $application->pet
        );


    // Gemini is still unavailable.
    if (! $explanation) {
        return redirect()
            ->route('adoption-applications.index')
            ->with(
                'error',
                'The AI model is temporarily unavailable. Please try again later.'
            );
    }


    // Save the successful explanation.
    $assessment->update([
        'gemini_explanation' => $explanation,
    ]);


    return redirect()
        ->route('adoption-applications.index')
        ->with(
            'success',
            'Compatibility explanation generated successfully.'
        );
}
}