<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdminAdoptionApplicationController extends Controller
{
    /**
     * Show pending adoption applications.
     */
    public function index()
    {
        $applications = AdoptionApplication::with([
            'user',
            'pet',
            'compatibilityAssessment',
        ])
            ->whereHas('compatibilityAssessment')
            ->where('status', 'Pending')
            ->latest()
            ->get();

        return view(
            'admin.applications.index',
            compact('applications')
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

        if (in_array(
            $application->status,
            ['Approved', 'Rejected']
        )) {
            return redirect()
                ->route('admin.adoption-records.show', $application)
                ->with(
                    'success',
                    'Application review completed successfully.'
                );
        }

        return redirect()
            ->route('admin.applications.show', $application)
            ->with(
                'success',
                'Application review updated successfully.'
            );
    }
}