<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Show administrator accounts.
     */
    public function index()
    {
        $administrators = User::where('role', 'admin')
            ->latest()
            ->get();

        return view(
            'super-admin.administrators.index',
            compact('administrators')
        );
    }


    /**
     * Show the create administrator form.
     */
    public function create()
    {
        return view(
            'super-admin.administrators.create'
        );
    }


    /**
     * Create a new administrator account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => 'admin',
        ]);

        return redirect()
            ->route('super-admin.administrators.index')
            ->with(
                'success',
                'Administrator account created successfully.'
            );  
    }

    /**
     * Show the edit administrator form.
     */
    public function edit(User $administrator)
    {
        if ($administrator->role !== 'admin') {
            abort(404);
        }

        return view(
            'super-admin.administrators.edit',
            compact('administrator')
        );
    }


    /**
     * Update an administrator account.
     */
    public function update(
        Request $request,
        User $administrator
    ) {
        if ($administrator->role !== 'admin') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $administrator->id,
            ],
        ]);

        $administrator->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('super-admin.administrators.index')
            ->with(
                'success',
                'Administrator account updated successfully.'
            );
    }


    /**
     * Delete an administrator account.
     */
    public function destroy(User $administrator)
    {
        if ($administrator->role !== 'admin') {
            abort(404);
        }

        $administrator->delete();

        return redirect()
            ->route('super-admin.administrators.index')
            ->with(
                'success',
                'Administrator account deleted successfully.'
            );
    }
}