<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdminAdoptionApplicationController extends Controller
{
    /**
     * Show all adoption applications.
     */
    public function index()
    {
        $applications = AdoptionApplication::with(['user', 'pet'])
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