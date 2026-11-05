<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\AdopterProfile;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Actual recorded shelter activity
        $recentActivities = DB::table('shelter_activities')
            ->orderByDesc('id')
            ->limit(4)
            ->get()
            ->map(function ($activity) {

                $link = match ($activity->activity_type) {
                    'pet_added' =>
                        route('pets.show', $activity->subject_id),

                    'application_submitted' =>
                        route('admin.applications.index'),

                    'application_approved',
                    'application_rejected' =>
                        route('admin.adoption-records.show', $activity->subject_id),

                    'account_approved',
                    'account_rejected',
                    'edit_requested',
                    'edit_approved',
                    'edit_rejected' =>
                        route('admin.adopters.show', $activity->subject_id),

                    default => route('admin.dashboard'),
                };

                $color = match ($activity->activity_type) {
                    'application_approved',
                    'account_approved',
                    'edit_approved' => 'green',

                    'application_rejected',
                    'account_rejected',
                    'edit_rejected' => 'red',

                    'edit_requested' => 'amber',

                    default => 'orange',
                };

                return [
                    'title' => $activity->title,
                    'description' => $activity->description,
                    'link' => $link,
                    'color' => $color,
                ];
            });

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