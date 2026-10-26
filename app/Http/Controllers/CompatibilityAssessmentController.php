<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\CompatibilityAssessment;
use App\Models\PetRecommendation;
use App\Services\CompatibilityService;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class CompatibilityAssessmentController extends Controller
{
    public function create(
        Request $request,
        AdoptionApplication $application
    ) {
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($application->compatibilityAssessment) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You already completed the compatibility assessment.'
                );
        }

        $profile = $request->user()->adopterProfile;

        if (! $profile || ! $profile->assessment_locked_at) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Please complete your compatibility assessment in your profile.'
                );
        }

        $application->load('pet');

        return view(
            'compatibility-assessments.create',
            compact('application')
        );
    }

    public function store(
        Request $request,
        AdoptionApplication $application,
        CompatibilityService $compatibilityService,
        GeminiService $geminiService
    ) {
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($application->compatibilityAssessment) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'You already completed the compatibility assessment.'
                );
        }

        $profile = $request->user()->adopterProfile;

        if (! $profile || ! $profile->assessment_locked_at) {
            return redirect()
                ->route('profile.edit')
                ->with(
                    'error',
                    'Complete your profile compatibility assessment first.'
                );
        }

        // These answers come from the saved adopter profile.
        $answers = [
            'care_ability' => $profile->care_ability,
            'available_time' => $profile->available_time,
            'household_compatibility' => $profile->household_compatibility,
            'living_environment' => $profile->living_environment,
            'pet_care_experience' => $profile->pet_care_experience,
            'activity_level' => $profile->activity_level,
        ];

        // Preserve one set of answers for this particular application.
        $assessment = CompatibilityAssessment::create([
            'adoption_application_id' => $application->id,
            ...$answers,
        ]);

        $application->load('pet');

        // Calculate the pet-specific compatibility score.
        $result = $compatibilityService->calculate(
            $assessment,
            $application->pet
        );

        $assessment->update($result);

        // Generate the AI explanation for the calculated result.
        $explanation = $geminiService
            ->generateCompatibilityExplanation(
                $assessment,
                $application->pet
            );

        if ($explanation) {
            $assessment->update([
                'gemini_explanation' => $explanation,
            ]);
        }

        // Get compatible alternative pets.
        $recommendedPets = $compatibilityService->recommendPets(
            $assessment,
            $application->pet
        );

        foreach ($recommendedPets as $recommendedPet) {

            $recommendationExplanation = $geminiService
                ->generateRecommendationExplanation(
                    $assessment,
                    $recommendedPet,
                    $recommendedPet->compatibility_score,
                    $recommendedPet->compatibility_classification
                );

            PetRecommendation::create([
                'compatibility_assessment_id' => $assessment->id,
                'pet_id' => $recommendedPet->id,

                'compatibility_score' =>
                    $recommendedPet->compatibility_score,

                'classification' =>
                    $recommendedPet->compatibility_classification,

                'gemini_explanation' =>
                    $recommendationExplanation,
            ]);
        }

        return redirect()
            ->route('adoption-applications.index')
            ->with(
                'success',
                'Your adoption application and compatibility assessment were submitted successfully.'
            );
    }

    public function retryExplanation(
        Request $request,
        AdoptionApplication $application,
        GeminiService $geminiService
    ) {
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        $application->load([
            'pet',
            'compatibilityAssessment',
        ]);

        $assessment = $application->compatibilityAssessment;

        if (! $assessment) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'Complete the compatibility assessment first.'
                );
        }

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

        if (! $explanation) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'The AI model is temporarily unavailable. Please try again later.'
                );
        }

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

    public function retryRecommendationExplanations(
        Request $request,
        AdoptionApplication $application,
        GeminiService $geminiService
    ) {
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        $application->load([
            'compatibilityAssessment.petRecommendations.pet',
        ]);

        $assessment = $application->compatibilityAssessment;

        if (! $assessment) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'Compatibility assessment not found.'
                );
        }

        $missingRecommendations =
            $assessment->petRecommendations
                ->whereNull('gemini_explanation');

        if ($missingRecommendations->isEmpty()) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'success',
                    'Recommendation explanations are already available.'
                );
        }

        foreach ($missingRecommendations as $recommendation) {

            $explanation = $geminiService
                ->generateRecommendationExplanation(
                    $assessment,
                    $recommendation->pet,
                    $recommendation->compatibility_score,
                    $recommendation->classification
                );

            if ($explanation) {
                $recommendation->update([
                    'gemini_explanation' => $explanation,
                ]);
            }
        }

        $stillMissing = $assessment->petRecommendations()
            ->whereNull('gemini_explanation')
            ->exists();

        if ($stillMissing) {
            return redirect()
                ->route('adoption-applications.index')
                ->with(
                    'error',
                    'Some AI recommendation explanations are still temporarily unavailable. Please try again later.'
                );
        }

        return redirect()
            ->route('adoption-applications.index')
            ->with(
                'success',
                'AI recommendation explanations generated successfully.'
            );
    }
}