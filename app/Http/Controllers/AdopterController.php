<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class AdopterController extends Controller
{
    /**
     * Show the adopter dashboard.
     */
    public function dashboard(Request $request)
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

        $pendingApplications = $applications
            ->where('status', 'Pending')
            ->count();

        $approvedApplications = $applications
            ->where('status', 'Approved')
            ->count();

        $rejectedApplications = $applications
            ->where('status', 'Rejected')
            ->count();

        $latestApplication = $applications->first();

        // Get pet IDs that rejected this adopter's application.
        $rejectedPetIds = $applications
            ->where('status', 'Rejected')
            ->pluck('pet_id');

        $recommendedPets = collect();

        if (
            $latestApplication
            && $latestApplication->compatibilityAssessment
        ) {
            $recommendedPets = $latestApplication
                ->compatibilityAssessment
                ->petRecommendations
                ->filter(
                    fn ($recommendation) =>
                        $recommendation->pet
                        && $recommendation->pet->status === 'Available'
                        && !$rejectedPetIds->contains(
                            $recommendation->pet_id
                        )
                )
                ->sortByDesc('compatibility_score')
                ->take(3);
        }

        // Show available pets except previously rejected ones.
        $availablePets = Pet::where('status', 'Available')
            ->whereNotIn('id', $rejectedPetIds)
            ->latest()
            ->take(3)
            ->get();

        return view(
            'adopter.dashboard',
            compact(
                'applications',
                'pendingApplications',
                'approvedApplications',
                'rejectedApplications',
                'latestApplication',
                'recommendedPets',
                'availablePets'
            )
        );
    }
}
