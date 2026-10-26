<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\AdopterProfile;
use App\Models\Pet;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingApplications = AdoptionApplication::whereHas(
            'compatibilityAssessment'
        )
            ->where('status', 'Pending')
            ->count();

        $approvedApplications = AdoptionApplication::where(
            'status',
            'Approved'
        )->count();

        $rejectedApplications = AdoptionApplication::where(
            'status',
            'Rejected'
        )->count();

        $availablePets = Pet::where(
            'status',
            'Available'
        )->count();

        $totalAdopters = User::where(
            'role',
            'adopter'
        )->count();

        $recentPendingApplications = AdoptionApplication::with([
            'user',
            'pet',
        ])
            ->whereHas('compatibilityAssessment')
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        $pendingEditRequests = AdopterProfile::with('user')
            ->where('edit_request_status', 'Pending')
            ->whereHas('user', function ($query) {
                $query->where('role', 'adopter');
            })
            ->latest('updated_at')
            ->get();

        return view('admin.dashboard', compact(
            'pendingApplications',
            'approvedApplications',
            'rejectedApplications',
            'availablePets',
            'totalAdopters',
            'recentPendingApplications',
            'pendingEditRequests'
        ));
    }
}