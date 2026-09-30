<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminAdopterController extends Controller
{
    /**
     * Show all registered adopters.
     */
    public function index()
    {
        $adopters = User::where('role', 'adopter')
            ->with('adopterProfile')
            ->withCount('adoptionApplications')
            ->latest()
            ->get();

        return view(
            'admin.adopters.index',
            compact('adopters')
        );
    }


    /**
     * Show one adopter and their applications.
     */
    public function show(User $adopter)
    {
        if ($adopter->role !== 'adopter') {
            abort(404);
        }

        $adopter->load([
            'adopterProfile',
            'adoptionApplications.pet',
            'adoptionApplications.compatibilityAssessment',
        ]);

        return view(
            'admin.adopters.show',
            compact('adopter')
        );
    }
}