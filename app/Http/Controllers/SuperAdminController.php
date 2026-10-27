<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdoptionApplication;
use App\Models\AdopterProfile;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Date filters for the graph.
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        $dateFrom = $validated['date_from'] ?? '';
        $dateTo = $validated['date_to'] ?? '';

        // System-wide statistics.
        $totalAdopters = User::where('role', 'adopter')->count();

        $totalAdministrators = User::where('role', 'admin')->count();

        $totalPets = Pet::count();

        $availablePets = Pet::where('status', 'Available')->count();

        $pendingApplications = AdoptionApplication::where(
            'status',
            'Pending'
        )->count();

        $approvedApplications = AdoptionApplication::where(
            'status',
            'Approved'
        )->count();

        $rejectedApplications = AdoptionApplication::where(
            'status',
            'Rejected'
        )->count();

        // Use the same graph filters as the Admin dashboard.
        $chartQuery = AdoptionApplication::query();

        if ($dateFrom) {
            $chartQuery->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }

        if ($dateTo) {
            $chartQuery->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
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

        // Recent application activity.
        $recentApplications = AdoptionApplication::with([
            'user',
            'pet',
        ])
            ->latest()
            ->take(5)
            ->get();

        // Pending compatibility assessment edit requests.
        $pendingEditRequests = AdopterProfile::with('user')
            ->where('edit_request_status', 'Pending')
            ->whereHas('user', function ($query) {
                $query->where('role', 'adopter');
            })
            ->latest('updated_at')
            ->get();

        return view(
            'super-admin.dashboard',
            compact(
                'totalAdopters',
                'totalAdministrators',
                'totalPets',
                'availablePets',
                'pendingApplications',
                'approvedApplications',
                'rejectedApplications',
                'recentApplications',
                'pendingEditRequests',
                'chartPending',
                'chartApproved',
                'chartRejected',
                'dateFrom',
                'dateTo'
            )
        );
    }

    public function index()
    {
        $administrators = User::where('role', 'admin')
            ->latest()
            ->get();

        return view(
            'super-admin.administrators.index',
            compact('administrators')
        );
    }

    public function create()
    {
        return view('super-admin.administrators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => 'admin',
        ]);

        return redirect()
            ->route('super-admin.administrators.index')
            ->with(
                'success',
                'Administrator account created successfully.'
            );
    }

    public function edit(User $administrator)
    {
        if ($administrator->role !== 'admin') {
            abort(404);
        }

        return view(
            'super-admin.administrators.edit',
            compact('administrator')
        );
    }

    public function update(
        Request $request,
        User $administrator
    ) {
        if ($administrator->role !== 'admin') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $administrator->id,
            ],
        ]);

        $administrator->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('super-admin.administrators.index')
            ->with(
                'success',
                'Administrator account updated successfully.'
            );
    }

    public function destroy(User $administrator)
    {
        if ($administrator->role !== 'admin') {
            abort(404);
        }

        $administrator->delete();

        return redirect()
            ->route('super-admin.administrators.index')
            ->with(
                'success',
                'Administrator account deleted successfully.'
            );
    }
}