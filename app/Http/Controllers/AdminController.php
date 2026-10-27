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

        // Existing dashboard statistics.
        $pendingApplications = AdoptionApplication::whereHas('compatibilityAssessment')
            ->where('status', 'Pending')->count();

        $approvedApplications = AdoptionApplication::where('status', 'Approved')->count();
        $rejectedApplications = AdoptionApplication::where('status', 'Rejected')->count();
        $availablePets = Pet::where('status', 'Available')->count();
        $totalAdopters = User::where('role', 'adopter')->count();

        // Existing filtered status graph.
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
            ->where('status', 'Approved')->count();

        $chartRejected = (clone $chartQuery)
            ->where('status', 'Rejected')->count();

        // NEW: Applications submitted during the last 12 months.
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

        // Existing applications needing review.
        $recentPendingApplications = AdoptionApplication::with(['user', 'pet'])
            ->whereHas('compatibilityAssessment')
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        // Existing compatibility edit requests.
        $pendingEditRequests = AdopterProfile::with('user')
            ->where('edit_request_status', 'Pending')
            ->whereHas('user', fn ($query) => $query->where('role', 'adopter'))
            ->latest('updated_at')
            ->get();

        return view('admin.dashboard', compact(
            'pendingApplications',
            'approvedApplications',
            'rejectedApplications',
            'availablePets',
            'totalAdopters',
            'recentPendingApplications',
            'pendingEditRequests',
            'chartPending',
            'chartApproved',
            'chartRejected',
            'dateFrom',
            'dateTo',
            'monthlyApplications'
        ));
    }
}