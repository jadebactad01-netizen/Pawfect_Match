<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdopterProfileController extends Controller
{
    /**
     * Show the logged-in user's adopter profile.
     */
    public function edit(Request $request)
    {
        $profile = $request->user()->adopterProfile;

        return view('profile.edit', compact('profile'));
    }

    /**
     * Save or update the logged-in user's adopter profile.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],

            'living_environment' => ['required', 'in:House,Apartment,Other'],
            'household' => ['required', 'in:Living alone,Adults only,Family with children'],
            'available_time' => ['required', 'in:Low,Moderate,High'],
            'pet_care_experience' => ['required', 'in:None,Some,Experienced'],
            'activity_level' => ['required', 'in:Low,Moderate,High'],
            'care_ability' => ['required', 'in:Limited,Moderate,High'],
        ]);

        $request->user()->adopterProfile()->updateOrCreate(
            [],
            $validated
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile saved successfully.');
    }
}