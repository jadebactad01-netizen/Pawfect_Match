<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminAdopterController extends Controller
{
    /**
     * Show all registered adopters.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::where(
            'role',
            'adopter'
        )
            ->with('adopterProfile')
            ->withCount('adoptionApplications')
            ->latest();

        if ($search) {
            $query->where(
                'name',
                'like',
                '%' . $search . '%'
            );
        }

        $adopters = $query->get();

        return view(
            'admin.adopters.index',
            compact(
                'adopters',
                'search'
            )
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