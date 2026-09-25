<?php

namespace App\Services;

use App\Models\CompatibilityAssessment;
use App\Models\Pet;
use Illuminate\Support\Facades\Http;

class GeminiService
{
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
- Keep the explanation to about 2 short paragraphs.
PROMPT;
    }
}