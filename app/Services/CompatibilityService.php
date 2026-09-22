<?php

namespace App\Services;

use App\Models\AdopterProfile;
use App\Models\Pet;

class CompatibilityService
{
    /**
     * Calculate the compatibility between an adopter and a pet.
     */
    public function calculate(AdopterProfile $profile, Pet $pet): array
    {
        $factors = [];

        // 1. Care Ability - 25 points
        $careLevels = [
            'Limited' => 1,
            'Moderate' => 2,
            'High' => 3,
        ];

        $careRequirements = [
            'Low' => 1,
            'Moderate' => 2,
            'High' => 3,
        ];

        $careScore = 0;

        if (
            isset($careLevels[$profile->care_ability]) &&
            isset($careRequirements[$pet->care_requirement]) &&
            $careLevels[$profile->care_ability] >= $careRequirements[$pet->care_requirement]
        ) {
            $careScore = 25;
        }

        $factors['care_ability'] = [
            'score' => $careScore,
            'possible' => 25,
        ];


        // 2. Available Time - 20 points
        $timeLevels = [
            'Low' => 1,
            'Moderate' => 2,
            'High' => 3,
        ];

        $timeScore = 0;

        if (
            isset($timeLevels[$profile->available_time]) &&
            isset($timeLevels[$pet->time_requirement]) &&
            $timeLevels[$profile->available_time] >= $timeLevels[$pet->time_requirement]
        ) {
            $timeScore = 20;
        }

        $factors['available_time'] = [
            'score' => $timeScore,
            'possible' => 20,
        ];


        // 3. Household Compatibility - 20 points
        $householdScore = 0;

        if (
            $pet->household_compatibility === 'Any' ||
            $profile->household === $pet->household_compatibility
        ) {
            $householdScore = 20;
        }

        $factors['household_compatibility'] = [
            'score' => $householdScore,
            'possible' => 20,
        ];


        // 4. Living Environment - 15 points
        $environmentScore = 0;

        if (
            $pet->living_environment === 'Any' ||
            $profile->living_environment === $pet->living_environment
        ) {
            $environmentScore = 15;
        }

        $factors['living_environment'] = [
            'score' => $environmentScore,
            'possible' => 15,
        ];


        // 5. Pet Care Experience - 10 points
        $experienceLevels = [
            'None' => 1,
            'Some' => 2,
            'Experienced' => 3,
        ];

        $experienceScore = 0;

        if (
            isset($experienceLevels[$profile->pet_care_experience]) &&
            isset($experienceLevels[$pet->experience_requirement]) &&
            $experienceLevels[$profile->pet_care_experience] >= $experienceLevels[$pet->experience_requirement]
        ) {
            $experienceScore = 10;
        }

        $factors['pet_care_experience'] = [
            'score' => $experienceScore,
            'possible' => 10,
        ];


        // 6. Activity Level - 10 points
        $activityScore = 0;

        if ($profile->activity_level === $pet->activity_level) {
            $activityScore = 10;
        }

        $factors['activity_level'] = [
            'score' => $activityScore,
            'possible' => 10,
        ];


        // Add all earned points.
        $earnedPoints =
            $careScore +
            $timeScore +
            $householdScore +
            $environmentScore +
            $experienceScore +
            $activityScore;

        $possiblePoints = 100;

        // Compatibility percentage:
        // earned points / possible points × 100
        $score = (int) round(
            ($earnedPoints / $possiblePoints) * 100
        );

        return [
            'score' => $score,
            'classification' => $this->classification($score),
            'factors' => $factors,
        ];
    }


    /**
     * Convert the percentage into a compatibility classification.
     */
    private function classification(int $score): string
    {
        if ($score >= 80) {
            return 'Highly Compatible';
        }

        if ($score >= 60) {
            return 'Moderately Compatible';
        }

        return 'Low Compatibility';
    }
}