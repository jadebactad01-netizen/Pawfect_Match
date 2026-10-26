<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPetController extends Controller
{
    public function manage(Request $request)
    {
        $search = $request->query('search');

        $query = Pet::latest();

        if ($search) {
            $query->where(
                'name',
                'like',
                '%' . $search . '%'
            );
        }

        $pets = $query->get();

        return view(
            'admin.pets.manage',
            compact('pets', 'search')
        );
    }

    public function add()
    {
        return view('admin.pets.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->petRules());

        $validated = $this->preparePetData($validated);

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

    public function edit(Pet $pet)
    {
        return view('admin.pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate($this->petRules());

        $validated = $this->preparePetData($validated);

        if ($request->hasFile('photo')) {

            $newPhoto = $request
                ->file('photo')
                ->store('pets', 'public');

            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }

            $validated['photo'] = $newPhoto;
        }

        $pet->update($validated);

        return redirect()
            ->route('admin.pets.manage')
            ->with('success', 'Pet updated successfully.');
    }

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

    private function petRules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:255',
            ],

            'type' => [
                'required', 'in:Dog,Cat',
            ],

            'sex' => [
                'required', 'in:Male,Female',
            ],

            'age_number' => [
                'required', 'integer', 'min:1',
                function ($attribute, $value, $fail) {
                    $unit = request('age_unit');

                    if ($unit === 'Months' && $value > 11) {
                        $fail('Age in months must be between 1 and 11.');
                    }

                    if ($unit === 'Years' && $value > 30) {
                        $fail('Age in years must be between 1 and 30.');
                    }
                },
            ],

            'age_unit' => [
                'required', 'in:Months,Years',
            ],

            'status' => [
                'required', 'in:Available,Unavailable',
            ],

            'description' => [
                'nullable', 'string',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            // New pet intake information
            'intake_type' => [
                'nullable',
                'required_with:intake_date',
                'in:Rescued,Surrendered',
            ],

            'intake_date' => [
                'nullable',
                'required_with:intake_type',
                'date',
                'before_or_equal:today',
            ],

            // New vaccination information
            'vaccination_type' => [
                'nullable',
                'required_with:vaccination_date',
                'string',
                'max:255',
            ],

            'vaccination_date' => [
                'nullable',
                'required_with:vaccination_type',
                'date',
                'before_or_equal:today',
            ],

            'care_requirement' => [
                'required', 'in:Low,Moderate,High',
            ],

            'time_requirement' => [
                'required', 'in:Low,Moderate,High',
            ],

            'household_compatibility' => [
                'required',
                'in:Living alone,Adults only,Family with children,Any',
            ],

            'living_environment' => [
                'required',
                'in:House,Apartment,Other,Any',
            ],

            'experience_requirement' => [
                'required', 'in:None,Some,Experienced',
            ],

            'activity_level' => [
                'required', 'in:Low,Moderate,High',
            ],
        ];
    }

    private function preparePetData(array $validated): array
    {
        $validated['age'] =
            $validated['age_number']
            . ' '
            . $validated['age_unit'];

        unset(
            $validated['age_number'],
            $validated['age_unit']
        );

        return $validated;
    }
}