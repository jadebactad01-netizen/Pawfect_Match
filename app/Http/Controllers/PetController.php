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
        // Show available pets only.
        $query = Pet::where('status', 'Available');

        // Get selected pet type.
        $type = $request->query('type');

        // Only accept Dogs or Cats.
        if (!in_array($type, ['Dog', 'Cat'], true)) {
            $type = null;
        }

        // Get additional filters.
        $breed = $request->query('breed');
        $color = $request->query('color');
        $size = $request->query('size');

        // Allow text values only.
        $breed = is_string($breed) ? $breed : null;
        $color = is_string($color) ? $color : null;
        $size = is_string($size) ? $size : null;

        // Default filter options.
        $breeds = collect();
        $colors = collect();

        if ($type) {

            // Filter by Dog or Cat.
            $query->where('type', $type);

            // Get breeds for selected pet type.
            $breeds = Pet::where('status', 'Available')
                ->where('type', $type)
                ->whereNotNull('breed')
                ->where('breed', '!=', '')
                ->distinct()
                ->orderBy('breed')
                ->pluck('breed');

            // Get colors for selected pet type.
            $colors = Pet::where('status', 'Available')
                ->where('type', $type)
                ->whereNotNull('color')
                ->where('color', '!=', '')
                ->distinct()
                ->orderBy('color')
                ->pluck('color');

            // Apply selected breed.
            if ($breed) {
                $query->where('breed', $breed);
            }

            // Apply selected color.
            if ($color) {
                $query->where('color', $color);
            }

            // Apply selected size.
            if (in_array($size, ['Small', 'Medium', 'Large'], true)) {
                $query->where('size', $size);
            } else {
                $size = null;
            }

        } else {

            // Clear extra filters when viewing All.
            $breed = null;
            $color = null;
            $size = null;
        }

        // Show 9 pets per page.
        $pets = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('pets.index', compact(
            'pets',
            'type',
            'breed',
            'color',
            'size',
            'breeds',
            'colors'
        ));
    }

    /**
     * Display one pet.
     */
    public function show(Request $request, Pet $pet)
    {
        $profile = null;
        $existingApplication = null;

        if ($request->user() && $request->user()->role === 'adopter') {

            $profile = $request->user()->adopterProfile;

            // Check whether this adopter already applied for this pet.
            $existingApplication = $request->user()
                ->adoptionApplications()
                ->with('compatibilityAssessment')
                ->where('pet_id', $pet->id)
                ->first();
        }

        return view('pets.show', compact(
            'pet',
            'profile',
            'existingApplication'
        ));
    }
}
