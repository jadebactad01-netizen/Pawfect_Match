<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display all available pets.
     */
    public function index(Request $request)
    {
        /*
        * Start by getting pets that are available for adoption.
        */
        $query = Pet::where('status', 'Available');


        /*
        * Get the pet type from the URL.
        *
        * Examples:
        * /pets?type=Dog
        * /pets?type=Cat
        */
        $type = $request->query('type');


        /*
        * Only allow Dog or Cat as filters.
        */
        if (in_array($type, ['Dog', 'Cat'])) {
            $query->where('type', $type);
        }


        /*
        * Run the query and get the pets.
        */
        $pets = $query->get();


        /*
        * Send both variables to the page.
        */
        return view('pets.index', compact('pets', 'type'));
    }


    /**
     * Display one pet.
     */
    public function show(Pet $pet)
    {
        return view('pets.show', compact('pet'));
    }
}