<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\AdopterProfile;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $dateFrom = $validated['date_from'] ?? '';
        $dateTo = $validated['date_to'] ?? '';

        // Shelter overview
        $pendingApplications = AdoptionApplication::whereHas('compatibilityAssessment')
            ->where('status', 'Pending')
            ->count();

        $approvedApplications = AdoptionApplication::where('status', 'Approved')
            ->count();

        $rejectedApplications = AdoptionApplication::where('status', 'Rejected')
            ->count();

        $availablePets = Pet::where('status', 'Available')->count();

        $totalAdopters = User::where('role', 'adopter')->count();

        $pendingAccountApprovals = User::where('role', 'adopter')
            ->where('approval_status', 'Pending')
            ->count();

        // Application status graph
        $chartQuery = AdoptionApplication::query();

        if ($dateFrom) {
            $chartQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $chartQuery->whereDate('created_at', '<=', $dateTo);
        }

        $chartPending = (clone $chartQuery)
            ->where('status', 'Pending')
            ->whereHas('compatibilityAssessment')
            ->count();

        $chartApproved = (clone $chartQuery)
            ->where('status', 'Approved')
            ->count();

        $chartRejected = (clone $chartQuery)
            ->where('status', 'Rejected')
            ->count();

        // Monthly adoption applications
        $monthlyStart = now()->startOfMonth()->subMonths(11);

        $monthlyCounts = AdoptionApplication::where(
            'created_at', '>=', $monthlyStart
        )
            ->where('created_at', '<', now()->startOfMonth()->addMonth())
            ->get(['created_at'])
            ->groupBy(fn ($application) => $application->created_at->format('Y-m'));

        $monthlyApplications = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $monthlyStart->copy()->addMonths($i);
            $key = $month->format('Y-m');

            $monthlyApplications[] = [
                'label' => $month->format('M'),
                'year' => $month->format('Y'),
                'count' => $monthlyCounts->has($key)
                    ? $monthlyCounts[$key]->count()
                    : 0,
            ];
        }

        // Applications needing review
        $recentPendingApplications = AdoptionApplication::with(['user', 'pet'])
            ->whereHas('compatibilityAssessment')
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        // Pending compatibility edit requests
        $pendingEditRequests = AdopterProfile::with('user')
            ->where('edit_request_status', 'Pending')
            ->whereHas('user', fn ($query) => $query->where('role', 'adopter'))
            ->latest('updated_at')
            ->get();

        // Recent shelter activity from existing records
        $recentActivities = collect();

        // Newly registered pets
        $recentPets = Pet::latest()->take(4)->get();

        foreach ($recentPets as $pet) {
            $recentActivities->push([
                'title' => 'New Pet Added',
                'description' => $pet->name . ' was added to the shelter.',
                'date' => $pet->created_at,
                'link' => route('pets.show', $pet),
                'color' => 'orange',
            ]);
        }

        // Submitted adoption applications
        $recentApplications = AdoptionApplication::with(['user', 'pet'])
            ->latest()
            ->take(4)
            ->get();

        foreach ($recentApplications as $application) {
            $recentActivities->push([
                'title' => 'Adoption Application Submitted',
                'description' => ($application->user?->name ?? 'An adopter')
                    . ' applied to adopt '
                    . ($application->pet?->name ?? 'a pet') . '.',
                'date' => $application->created_at,
                'link' => route('admin.applications.show', $application),
                'color' => 'green',
            ]);
        }

        // Currently pending requests to edit compatibility answers
        foreach ($pendingEditRequests->take(4) as $profile) {
            $recentActivities->push([
                'title' => 'Compatibility Edit Request',
                'description' => ($profile->user?->name ?? 'An adopter')
                    . ' requested to edit their assessment.',
                'date' => $profile->updated_at,
                'link' => route('admin.adopters.show', $profile->user),
                'color' => 'amber',
            ]);
        }

        // Show the four most recent entries
        $recentActivities = $recentActivities
            ->sortByDesc('date')
            ->take(4)
            ->values();

        return view('admin.dashboard', compact(
            'pendingApplications',
            'approvedApplications',
            'rejectedApplications',
            'availablePets',
            'totalAdopters',
            'pendingAccountApprovals',
            'recentPendingApplications',
            'pendingEditRequests',
            'recentActivities',
            'chartPending',
            'chartApproved',
            'chartRejected',
            'dateFrom',
            'dateTo',
            'monthlyApplications'
        ));
    }
}