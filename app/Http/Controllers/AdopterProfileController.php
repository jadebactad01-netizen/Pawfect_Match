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

            'living_environment' => ['required', 'string'],
            'household' => ['required', 'string'],
            'available_time' => ['required', 'string'],
            'pet_care_experience' => ['required', 'string'],
            'activity_level' => ['required', 'string'],
            'care_ability' => ['required', 'string'],
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