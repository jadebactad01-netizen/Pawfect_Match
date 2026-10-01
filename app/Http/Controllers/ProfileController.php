<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the logged-in user's profile.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        $profile = $user->role === 'adopter'
            ? $user->adopterProfile
            : null;

        return view(
            'profile.edit',
            compact('user', 'profile')
        );
    }

    /**
     * Update the logged-in user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ];

        /*
         * Adopter-specific profile information.
         */
        if ($user->role === 'adopter') {
            $rules['phone_number'] = [
                'nullable',
                'string',
                'max:20',
            ];

            $rules['address'] = [
                'nullable',
                'string',
                'max:255',
            ];
        }

        $validated = $request->validate($rules);

        /*
         * Update account information.
         */
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make(
                $validated['password']
            );
        }

        $user->save();

        /*
         * Update adopter-only profile information.
         */
        if ($user->role === 'adopter') {
            $user->adopterProfile()->updateOrCreate(
                [],
                [
                    'phone_number' => $validated['phone_number'],
                    'address' => $validated['address'],
                ]
            );
        }

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}