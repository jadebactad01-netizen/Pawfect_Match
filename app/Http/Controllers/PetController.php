<?php

namespace App\Http\Controllers;

use App\Models\Pet;

class PetController extends Controller
{
    /**
     * Display all available pets.
     */
    public function index()
    {
        $pets = Pet::where('status', 'Available')->get();

        return view('pets.index', compact('pets'));
    }


    /**
     * Display one pet.
     */
    public function show(Pet $pet)
    {
        return view('pets.show', compact('pet'));
    }
}