<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminAdopterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::where('role', 'adopter')
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
            compact('adopters', 'search')
        );
    }

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

        return view('admin.adopters.show', compact('adopter'));
    }

    public function reviewEditRequest(Request $request, User $adopter)
    {
        if ($adopter->role !== 'adopter') {
            abort(404);
        }

        $validated = $request->validate([
            'decision' => ['required', 'in:Approved,Rejected'],
        ]);

        $profile = $adopter->adopterProfile;

        if (! $profile || $profile->edit_request_status !== 'Pending') {
            return back()->with(
                'error',
                'There is no pending edit request for this adopter.'
            );
        }

        $approved = $validated['decision'] === 'Approved';

        $profile->update([
            'edit_request_status' => $validated['decision'],
            'edit_permission_granted' => $approved,
        ]);

        return back()->with(
            'success',
            $approved
                ? 'Assessment editing request approved.'
                : 'Assessment editing request rejected.'
        );
    }
}