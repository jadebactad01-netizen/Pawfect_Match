<?php

namespace App\Providers;

use App\Models\AdopterProfile;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Store an activity when an actual event occurs.
        $recordActivity = function (
            string $type,
            int $subjectId,
            string $title,
            string $description
        ): void {
            DB::table('shelter_activities')->insert([
                'activity_type' => $type,
                'subject_id' => $subjectId,
                'title' => $title,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };

        // A new pet is registered.
        Pet::created(function (Pet $pet) use ($recordActivity) {
            $recordActivity(
                'pet_added',
                $pet->id,
                'New Pet Added',
                $pet->name . ' was added to the shelter.'
            );
        });

        // An adopter submits a new application.
        AdoptionApplication::created(
            function (AdoptionApplication $application) use ($recordActivity) {
                $recordActivity(
                    'application_submitted',
                    $application->id,
                    'Adoption Application Submitted',
                    ($application->user?->name ?? 'An adopter')
                        . ' applied to adopt '
                        . ($application->pet?->name ?? 'a pet') . '.'
                );
            }
        );

        // An administrator approves or rejects an application.
        AdoptionApplication::updated(
            function (AdoptionApplication $application) use ($recordActivity) {
                if (! $application->wasChanged('status')) {
                    return;
                }

                $status = $application->status;

                if (! in_array($status, ['Approved', 'Rejected'])) {
                    return;
                }

                $adopter = $application->user?->name ?? 'An adopter';
                $pet = $application->pet?->name ?? 'a pet';

                $recordActivity(
                    'application_' . strtolower($status),
                    $application->id,
                    'Adoption Application ' . $status,
                    $adopter . "'s application for " . $pet
                        . ' was ' . strtolower($status) . '.'
                );
            }
        );

        // An adopter account is approved or rejected.
        User::updated(function (User $user) use ($recordActivity) {
            if (
                $user->role !== 'adopter'
                || ! $user->wasChanged('approval_status')
            ) {
                return;
            }

            $status = $user->approval_status;

            if (! in_array($status, ['Approved', 'Rejected'])) {
                return;
            }

            $recordActivity(
                'account_' . strtolower($status),
                $user->id,
                'Adopter Account ' . $status,
                $user->name . "'s account was "
                    . strtolower($status) . '.'
            );
        });

        // Compatibility assessment edit requests.
        AdopterProfile::updated(
            function (AdopterProfile $profile) use ($recordActivity) {
                if (! $profile->wasChanged('edit_request_status')) {
                    return;
                }

                $status = $profile->edit_request_status;
                $adopter = $profile->user?->name ?? 'An adopter';

                if ($status === 'Pending') {
                    $recordActivity(
                        'edit_requested',
                        $profile->user_id,
                        'Compatibility Edit Request',
                        $adopter . ' requested to edit their assessment.'
                    );

                    return;
                }

                if (in_array($status, ['Approved', 'Rejected'])) {
                    $recordActivity(
                        'edit_' . strtolower($status),
                        $profile->user_id,
                        'Edit Request ' . $status,
                        $adopter . "'s assessment edit request was "
                            . strtolower($status) . '.'
                    );
                }
            }
        );
    }
}