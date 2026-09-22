<?php

namespace App\Services;

use App\Models\AdopterProfile;
use App\Models\Pet;

class CompatibilityService
{
    public function calculate(AdopterProfile $profile, Pet $pet): array
    {
        $score = 0;

        // We will calculate the six compatibility factors here.

        return [
            'score' => $score,
            'classification' => $this->classification($score),
        ];
    }

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