<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

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
        ]);


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
        ]);


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
        $pet->delete();


        return redirect()
            ->route('admin.pets.manage')
            ->with('success', 'Pet deleted successfully.');
    }
}