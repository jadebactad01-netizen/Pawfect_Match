<?php

namespace App\Services;

use App\Models\CompatibilityAssessment;
use App\Models\Pet;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    /**
     * Ask Gemini to analyze the six compatibility factors.
     */
    public function analyzeCompatibility(
        CompatibilityAssessment $assessment,
        Pet $pet
    ): ?array {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (! $apiKey) {
            return null;
        }

        $prompt = $this->buildAnalysisPrompt(
            $assessment,
            $pet
        );

        try {

            $response = Http::timeout(20)
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt,
                                    ],
                                ],
                            ],
                        ],

                        'generationConfig' => [
                            'responseMimeType' => 'application/json',
                        ],
                    ]
                );

            if ($response->failed()) {
                return null;
            }

            $text = $response->json(
                'candidates.0.content.parts.0.text'
            );

            if (! $text) {
                return null;
            }

            $analysis = json_decode($text, true);

            if (! is_array($analysis)) {
                return null;
            }

            return $analysis;

        } catch (\Exception $exception) {

            return null;

        }
    }
    /**
     * Generate a simple explanation of the compatibility result.
     */
    public function generateCompatibilityExplanation(
        CompatibilityAssessment $assessment,
        Pet $pet
    ): ?string {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (! $apiKey) {
            return null;
        }


        $prompt = $this->buildCompatibilityPrompt(
            $assessment,
            $pet
        );


        try {

            $response = Http::timeout(20)
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt,
                                    ],
                                ],
                            ],
                        ],
                    ]
                );


            if ($response->failed()) {
                return null;
            }


            return $response->json(
                'candidates.0.content.parts.0.text'
            );

        } catch (\Exception $exception) {

            return null;

        }
    }


    /**
     * Build the information that Gemini will explain.
     */
    private function buildCompatibilityPrompt(
        CompatibilityAssessment $assessment,
        Pet $pet
    ): string {
        return <<<PROMPT
    You are helping explain a pet adoption compatibility result
    for the PAWFECT pet adoption system.

    The compatibility score has already been calculated by the
    system. Do NOT calculate, change, or question the score.

    Selected pet:
    Name: {$pet->name}
    Type: {$pet->type}

    Adopter assessment:
    Care ability: {$assessment->care_ability}
    Available time: {$assessment->available_time}
    Household: {$assessment->household_compatibility}
    Living environment: {$assessment->living_environment}
    Pet-care experience: {$assessment->pet_care_experience}
    Activity level: {$assessment->activity_level}

    Pet requirements:
    Care requirement: {$pet->care_requirement}
    Time requirement: {$pet->time_requirement}
    Household compatibility: {$pet->household_compatibility}
    Living environment: {$pet->living_environment}
    Experience requirement: {$pet->experience_requirement}
    Activity level: {$pet->activity_level}

    System-calculated result:
    Compatibility score: {$assessment->total_score}%
    Classification: {$assessment->classification}

    Explain this compatibility result to the adopter.

    Requirements:
    - Use friendly and simple language.
    - Explain the strongest matching factors.
    - Mention important mismatches or considerations honestly.
    - Do not change the compatibility score.
    - Do not claim that adoption is guaranteed.
    - Do not approve or reject the adoption application.
    - Keep the explanation brief, around 2 to 3 sentences.
    - Do not repeat every assessment factor.
    PROMPT;
    }

    /**
     * Build the prompt used for AI compatibility analysis.
     */
    private function buildAnalysisPrompt(
        CompatibilityAssessment $assessment,
        Pet $pet
    ): string {
        return <<<PROMPT
    You are analyzing adopter-to-pet compatibility
    for the PAWFECT pet adoption system.

    Analyze exactly these six compatibility factors:

    1. Ability to provide proper care
    2. Available time
    3. Household compatibility
    4. Living environment
    5. Pet-care experience
    6. Activity level

    Adopter assessment:
    Care ability: {$assessment->care_ability}
    Available time: {$assessment->available_time}
    Household: {$assessment->household_compatibility}
    Living environment: {$assessment->living_environment}
    Pet-care experience: {$assessment->pet_care_experience}
    Activity level: {$assessment->activity_level}

    Pet requirements:
    Care requirement: {$pet->care_requirement}
    Time requirement: {$pet->time_requirement}
    Household compatibility: {$pet->household_compatibility}
    Living environment: {$pet->living_environment}
    Experience requirement: {$pet->experience_requirement}
    Activity level: {$pet->activity_level}

    For each factor, classify the match as exactly one of:

    "full"
    "partial"
    "none"

    Use:
    - "full" when the adopter clearly meets or exceeds the pet's requirement.
    - "partial" when the adopter can meet the requirement only partly.
    - "none" when the adopter does not meet the requirement.

    Return ONLY valid JSON using exactly this structure:

    {
        "care": "full",
        "time": "partial",
        "household": "full",
        "environment": "full",
        "experience": "partial",
        "activity": "full"
    }

    Do not include:
    - compatibility percentages
    - numerical scores
    - classifications
    - recommendations
    - explanations
    - Markdown

    Only evaluate the six factors.
    PROMPT;
    }
}