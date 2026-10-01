<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the Admin dashboard.
     */
    public function dashboard()
    {
        $pendingApplications = AdoptionApplication::where(
            'status',
            'Pending'
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
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'pendingApplications',
                'availablePets',
                'totalAdopters',
                'recentPendingApplications'
            )
        );
    }
}