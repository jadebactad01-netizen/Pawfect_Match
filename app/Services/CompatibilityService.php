<?php

namespace App\Services;

use App\Models\CompatibilityAssessment;
use App\Models\Pet;

class CompatibilityService
{
    /**
     * Calculate compatibility between an assessment and a pet.
     */
    public function calculate(
        CompatibilityAssessment $assessment,
        Pet $pet
    ): array {
        $careScore = $this->levelScore(
            $assessment->care_ability,
            $pet->care_requirement,
            25
        );

        $timeScore = $this->levelScore(
            $assessment->available_time,
            $pet->time_requirement,
            20
        );

        $householdScore = $this->exactScore(
            $assessment->household_compatibility,
            $pet->household_compatibility,
            20
        );

        $environmentScore = $this->exactScore(
            $assessment->living_environment,
            $pet->living_environment,
            15
        );

        $experienceScore = $this->experienceScore(
            $assessment->pet_care_experience,
            $pet->experience_requirement,
            10
        );

        $activityScore = $this->levelScore(
            $assessment->activity_level,
            $pet->activity_level,
            10
        );


        $totalScore =
            $careScore +
            $timeScore +
            $householdScore +
            $environmentScore +
            $experienceScore +
            $activityScore;


        if ($totalScore >= 80) {
            $classification = 'Highly Compatible';
        } elseif ($totalScore >= 60) {
            $classification = 'Moderately Compatible';
        } else {
            $classification = 'Low Compatibility';
        }


        return [
            'care_score' => $careScore,
            'time_score' => $timeScore,
            'household_score' => $householdScore,
            'environment_score' => $environmentScore,
            'experience_score' => $experienceScore,
            'activity_score' => $activityScore,

            'total_score' => $totalScore,
            'classification' => $classification,
        ];
    }


    /**
     * Score Low / Moderate / High values.
     *
     * Full match or higher ability = full points.
     * One level below = partial points.
     * Two levels below = zero.
     */
    private function levelScore(
        string $adopterValue,
        string $petRequirement,
        int $maxPoints
    ): int {
        $levels = [
            'Low' => 1,
            'Moderate' => 2,
            'High' => 3,

            // Care uses different words but same levels.
            'Limited' => 1,
        ];

        $adopterLevel = $levels[$adopterValue] ?? 0;
        $petLevel = $levels[$petRequirement] ?? 0;

        if ($adopterLevel >= $petLevel) {
            return $maxPoints;
        }

        if ($adopterLevel === $petLevel - 1) {
            return (int) round($maxPoints * 0.5);
        }

        return 0;
    }

    /**
     * Score values that need an exact match.
     *
     * If the pet accepts Any, every adopter gets full points.
     */
    private function exactScore(
        string $adopterValue,
        string $petRequirement,
        int $maxPoints
    ): int {
        if ($petRequirement === 'Any') {
            return $maxPoints;
        }

        if ($adopterValue === $petRequirement) {
            return $maxPoints;
        }

        return 0;
    }

    /**
     * Score pet-care experience.
     */
    private function experienceScore(
        string $adopterValue,
        string $petRequirement,
        int $maxPoints
    ): int {
        $levels = [
            'None' => 1,
            'Some' => 2,
            'Experienced' => 3,
        ];

        $adopterLevel = $levels[$adopterValue] ?? 0;
        $petLevel = $levels[$petRequirement] ?? 0;

        if ($adopterLevel >= $petLevel) {
            return $maxPoints;
        }

        if ($adopterLevel === $petLevel - 1) {
            return (int) round($maxPoints * 0.5);
        }

        return 0;
    }
}