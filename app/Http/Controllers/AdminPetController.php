<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPetController extends Controller
{
    /**
     * Show all pets for shelter management.
     */
    public function manage()
    {
        $pets = Pet::latest()->get();

        return view('admin.pets.manage', compact('pets'));
    }


    /**
     * Show the form for adding a pet.
     */
    public function add()
    {
        return view('admin.pets.add');
    }


    /**
     * Save a new pet to the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:Dog,Cat'],
            'sex' => ['required', 'in:Male,Female'],
            'age_number' => [
                'required',
                'integer',
                'min:1',
            ],

            'age_unit' => [
                'required',
                'in:Months,Years',
            ],
            'status' => ['required', 'in:Available,Unavailable'],
            'description' => ['nullable', 'string'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'care_requirement' => ['required', 'in:Low,Moderate,High'],
            'time_requirement' => ['required', 'in:Low,Moderate,High'],
            'household_compatibility' => ['required', 'in:Living alone,Adults only,Family with children,Any'],
            'living_environment' => ['required', 'in:House,Apartment,Other,Any'],
            'experience_requirement' => ['required', 'in:None,Some,Experienced'],
            'activity_level' => ['required', 'in:Low,Moderate,High'],
        ]);

        if (
            $validated['age_unit'] === 'Months'
            && $validated['age_number'] > 11
        ) {
            return back()
                ->withErrors([
                    'age_number' =>
                        'Age in months must be between 1 and 11.',
                ])
                ->withInput();
        }

        if (
            $validated['age_unit'] === 'Years'
            && $validated['age_number'] > 30
        ) {
            return back()
                ->withErrors([
                    'age_number' =>
                        'Age in years must be between 1 and 30.',
                ])
                ->withInput();
        }

        $validated['age'] =
            $validated['age_number'] . ' ' . $validated['age_unit'];

        unset(
            $validated['age_number'],
            $validated['age_unit']
        );

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request
                ->file('photo')
                ->store('pets', 'public');
        }

        Pet::create($validated);


        return redirect()
            ->route('admin.pets.manage')
            ->with('success', 'Pet added successfully.');
    }
    
    /**
     * Show the form for editing a pet.
     */
    public function edit(Pet $pet)
    {
        return view('admin.pets.edit', compact('pet'));
    }


    /**
     * Update an existing pet.
     */
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:Dog,Cat'],
            'sex' => ['required', 'in:Male,Female'],
            'age_number' => [
                'required',
                'integer',
                'min:1',
            ],

            'age_unit' => [
                'required',
                'in:Months,Years',
            ],
            'status' => ['required', 'in:Available,Unavailable'],
            'description' => ['nullable', 'string'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'care_requirement' => ['required', 'in:Low,Moderate,High'],
            'time_requirement' => ['required', 'in:Low,Moderate,High'],
            'household_compatibility' => ['required', 'in:Living alone,Adults only,Family with children,Any'],
            'living_environment' => ['required', 'in:House,Apartment,Other,Any'],
            'experience_requirement' => ['required', 'in:None,Some,Experienced'],
            'activity_level' => ['required', 'in:Low,Moderate,High'],
        ]);

        if (
            $validated['age_unit'] === 'Months'
            && $validated['age_number'] > 11
        ) {
            return back()
                ->withErrors([
                    'age_number' =>
                        'Age in months must be between 1 and 11.',
                ])
                ->withInput();
        }

        if (
            $validated['age_unit'] === 'Years'
            && $validated['age_number'] > 30
        ) {
            return back()
                ->withErrors([
                    'age_number' =>
                        'Age in years must be between 1 and 30.',
                ])
                ->withInput();
        }

        $validated['age'] =
            $validated['age_number'] . ' ' . $validated['age_unit'];

        unset(
            $validated['age_number'],
            $validated['age_unit']
        );

        if ($request->hasFile('photo')) {

            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }

            $validated['photo'] = $request
                ->file('photo')
                ->store('pets', 'public');
        }

        $pet->update($validated);


        return redirect()
            ->route('admin.pets.manage')
            ->with('success', 'Pet updated successfully.');
    }


    /**
     * Delete a pet.
     */
    public function destroy(Pet $pet)
    {
        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo);
        }
        
        $pet->delete();


        return redirect()
            ->route('admin.pets.manage')
            ->with('success', 'Pet deleted successfully.');
    }
}