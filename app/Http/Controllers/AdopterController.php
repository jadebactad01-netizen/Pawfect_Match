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

        $latestApplication = $applications->first();

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
                )
                ->sortByDesc('compatibility_score')
                ->take(3);
        }

        $availablePets = Pet::where('status', 'Available')
            ->latest()
            ->take(3)
            ->get();

        return view(
            'adopter.dashboard',
            compact(
                'applications',
                'pendingApplications',
                'approvedApplications',
                'latestApplication',
                'recommendedPets',
                'availablePets'
            )
        );
    }
}