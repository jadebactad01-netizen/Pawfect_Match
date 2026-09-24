<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdminAdoptionApplicationController extends Controller
{
    /**
     * Show all adoption applications.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        // Count all applications by status.
    $allCount = AdoptionApplication::whereHas(
        'compatibilityAssessment'
    )->count();


    $pendingCount = AdoptionApplication::whereHas(
        'compatibilityAssessment'
    )
        ->where('status', 'Pending')
        ->count();


    $approvedCount = AdoptionApplication::whereHas(
        'compatibilityAssessment'
    )
        ->where('status', 'Approved')
        ->count();


    $rejectedCount = AdoptionApplication::whereHas(
        'compatibilityAssessment'
    )
        ->where('status', 'Rejected')
        ->count();


        // Start the applications query.
        $query = AdoptionApplication::with([
            'user',
            'pet',
            'compatibilityAssessment',
        ])
            ->whereHas('compatibilityAssessment');

        // Apply the selected filter.
        if (in_array($status, ['Pending', 'Approved', 'Rejected'])) {
            $query->where('status', $status);
        }

        $applications = $query
            ->latest()
            ->get();


        return view(
            'admin.applications.index',
            compact(
                'applications',
                'status',
                'allCount',
                'pendingCount',
                'approvedCount',
                'rejectedCount'
            )
        );
    }


    /**
     * Show one adoption application.
     */
    public function show(AdoptionApplication $application)
    {
        $application->load([
            'user.adopterProfile',
            'pet',
            'compatibilityAssessment',
        ]);

        if (! $application->compatibilityAssessment) {
            return redirect()
                ->route('admin.applications.index')
                ->with(
                    'error',
                    'This application has not completed the compatibility assessment yet.'
                );
        }

        return view(
            'admin.applications.show',
            compact('application')
        );
    }

    /**
     * Update evaluator notes and application status.
     */
    public function update(
        Request $request,
        AdoptionApplication $application
    ) {

        if (! $application->compatibilityAssessment) {
        return redirect()
            ->route('admin.applications.index')
            ->with(
                'error',
                'This application has not completed the compatibility assessment yet.'
            );
        }

        $validated = $request->validate([
            'evaluator_notes' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'status' => [
                'required',
                'in:Pending,Approved,Rejected',
            ],
        ]);

        $application->update($validated);

        return redirect()
            ->route('admin.applications.show', $application)
            ->with(
                'success',
                'Application review updated successfully.'
            );
    }
}