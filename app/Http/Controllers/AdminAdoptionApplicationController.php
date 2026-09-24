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

        // Start the query and load the applicant and pet.
        $query = AdoptionApplication::with(['user', 'pet']);

        // Filter only when a valid status was selected.
        if (in_array($status, ['Pending', 'Approved', 'Rejected'])) {
            $query->where('status', $status);
        }

        $applications = $query
            ->latest()
            ->get();

        return view(
            'admin.applications.index',
            compact('applications', 'status')
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
        ]);

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