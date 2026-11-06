<?php

namespace App\Services;

use App\Models\CompatibilityAssessment;
use App\Models\Pet;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private ?string $lastError = null;
    private ?int $lastStatus = null;

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    public function getLastStatus(): ?int
    {
        return $this->lastStatus;
    }

    public function generateCompatibilityExplanation(
        CompatibilityAssessment $assessment,
        Pet $pet
    ): ?string {
        return $this->requestGemini(
            $this->buildCompatibilityPrompt($assessment, $pet)
        );
    }

    public function generateRecommendationExplanation(
        CompatibilityAssessment $assessment,
        Pet $pet,
        int $score,
        string $classification
    ): ?string {
        return $this->requestGemini(
            $this->buildRecommendationPrompt(
                $assessment,
                $pet,
                $score,
                $classification
            )
        );
    }

    /**
     * Send only one request to Gemini.
     */
    private function requestGemini(string $prompt): ?string
    {
        $this->lastError = null;
        $this->lastStatus = null;

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (! $apiKey || ! $model) {
            $this->lastError =
                'The AI service is not configured. Please contact the administrator.';

            return null;
        }

        try {
            // No automatic retries.
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
                                    ['text' => $prompt],
                                ],
                            ],
                        ],
                    ]
                );

            $this->lastStatus = $response->status();

            // Record request status and actual token usage.
            // Google may omit token counts on failed requests.
            Log::info('Gemini API request', [
                'model' => $model,
                'status' => $response->status(),
                'input_tokens' => $response->json(
                    'usageMetadata.promptTokenCount'
                ),
                'output_tokens' => $response->json(
                    'usageMetadata.candidatesTokenCount'
                ),
                'thinking_tokens' => $response->json(
                    'usageMetadata.thoughtsTokenCount'
                ),
                'total_tokens' => $response->json(
                    'usageMetadata.totalTokenCount'
                ),
            ]);

            if ($response->failed()) {
                $this->lastError = $this->explainError(
                    $response->status(),
                    $response->json('error.message', ''),
                    $response->json('error.details', [])
                );

                return null;
            }

            $explanation = $response->json(
                'candidates.0.content.parts.0.text'
            );

            if (! is_string($explanation) ||
                trim($explanation) === '') {

                $this->lastError =
                    'Gemini returned no explanation. Please try again.';

                return null;
            }

            return $explanation;

        } catch (\Throwable $exception) {

            Log::warning('Gemini connection failed', [
                'model' => $model,
                'exception_type' => get_class($exception),
            ]);

            $this->lastError =
                'Unable to connect to Gemini. The request may have timed out or encountered a network problem.';

            return null;
        }
    }

    /**
     * Explain Gemini API errors.
     */
    private function explainError(
        int $code,
        string $message,
        array $details
    ): string {
        $information = strtolower(
            $message . ' ' . json_encode($details)
        );

        if ($code === 503) {
            return 'Gemini is experiencing high traffic or temporary service unavailability (HTTP 503). Please try again later.';
        }

        if ($code === 429) {

            if (
                str_contains($information, 'perday') ||
                str_contains($information, 'per_day') ||
                str_contains($information, 'per day') ||
                str_contains($information, 'daily') ||
                str_contains($information, 'rpd') ||
                str_contains($information, 'tpd') ||
                str_contains($information, 'quota_exceeded')
            ) {
                return 'The Gemini daily quota has been reached (HTTP 429). Please wait for the quota to reset.';
            }

            if (
                str_contains($information, 'spend cap') ||
                str_contains($information, 'spending limit') ||
                str_contains($information, 'balance depleted')
            ) {
                return 'The Gemini API spending limit has been reached (HTTP 429). Please contact the administrator.';
            }

            if (
                str_contains($information, 'perminute') ||
                str_contains($information, 'per_minute') ||
                str_contains($information, 'per minute') ||
                str_contains($information, 'rpm') ||
                str_contains($information, 'tpm') ||
                str_contains($information, 'rate_limit_exceeded') ||
                str_contains($information, 'too_many_requests')
            ) {
                return 'Too many Gemini requests were made in a short period (HTTP 429). Please wait before retrying.';
            }

            return 'A Gemini API limit was reached (HTTP 429). The response did not specify whether it was a temporary rate limit or an exhausted quota.';
        }

        if ($code === 400) {
            return 'Gemini rejected the AI request (HTTP 400). Please contact the administrator.';
        }

        if ($code === 401 || $code === 403) {
            return 'Gemini authentication or access failed (HTTP ' .
                $code .
                '). Please contact the administrator.';
        }

        if ($code === 404) {
            return 'The configured Gemini model was not found (HTTP 404). Please contact the administrator.';
        }

        if ($code === 500) {
            return 'Gemini encountered an internal server error (HTTP 500). Please try again later.';
        }

        if ($code === 504) {
            return 'Gemini took too long to respond (HTTP 504). Please try again later.';
        }

        return 'Gemini could not generate the explanation (HTTP ' .
            $code .
            '). Please try again later or contact the administrator.';
    }

    /**
     * Build compatibility explanation prompt.
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
     * Build recommendation explanation prompt.
     */
    private function buildRecommendationPrompt(
        CompatibilityAssessment $assessment,
        Pet $pet,
        int $score,
        string $classification
    ): string {
        return <<<PROMPT
        You are explaining a pet recommendation
        for the PAWFECT pet adoption system.

        The system has already calculated the compatibility
        score and selected this pet as one of the adopter's
        recommended alternatives.

        Do NOT calculate, change, or question the score.

        Recommended pet:
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
        Compatibility score: {$score}%
        Classification: {$classification}

        Briefly explain why this pet may be a suitable
        alternative for the adopter.

        Requirements:
        - Use friendly and simple language.
        - Focus on the strongest matching factors.
        - Mention an important consideration if necessary.
        - Do not change or calculate the compatibility score.
        - Do not approve or guarantee the adoption.
        - Keep the explanation to 1 or 2 short sentences.
        PROMPT;
    }
}
