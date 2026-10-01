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
            'age' => ['required', 'string', 'max:255'],
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
            'age' => ['required', 'string', 'max:255'],
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