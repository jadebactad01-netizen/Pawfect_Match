<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminAccountApprovalController extends Controller
{
    public function index(Request $request)
    {
        $selectedUser = $request->query('user');

        $query = User::where('role', 'adopter')
            ->whereIn('approval_status', [
                'Pending',
                'Rejected',
            ])
            ->latest();

        // Show only the selected adopter when reviewing from Adopters.
        if ($selectedUser) {
            $query->where('id', $selectedUser);
        }

        $users = $query->paginate(10)->withQueryString();

        return view(
            'admin.adopters.approvals',
            compact('users', 'selectedUser')
        );
    }

    public function showId(User $user)
    {
        if (
            $user->role !== 'adopter'
            || ! $user->valid_id_path
            || ! Storage::disk('local')->exists($user->valid_id_path)
        ) {
            abort(404);
        }

        $path = Storage::disk('local')->path($user->valid_id_path);

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function review(Request $request, User $user)
    {
        if (
            $user->role !== 'adopter'
            || $user->approval_status !== 'Pending'
        ) {
            abort(404);
        }

        $validated = $request->validate([
            'decision' => [
                'required',
                Rule::in(['Approved', 'Rejected']),
            ],

            'rejection_reason' => [
                'required_if:decision,Rejected',
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $user->update([
            'approval_status' => $validated['decision'],

            'rejection_reason' => $validated['decision'] === 'Rejected'
                ? trim($validated['rejection_reason'])
                : null,
        ]);

        return redirect()
            ->route('admin.account-approvals.index')
            ->with(
                'success',
                'Account ' .
                strtolower($validated['decision']) .
                ' successfully.'
            );
    }
}
