@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl px-6">

        <div>

            <p class="font-semibold text-orange-500">
                Super Administration
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                System Overview
            </h1>

            <p class="mt-2 text-gray-600">
                Monitor the overall activity and current
                status of Pawfect Match.
            </p>

        </div>


        {{-- System counts --}}
        <div class="mt-8 grid gap-5
                    sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl bg-white
                        p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    Registered Adopters
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalAdopters }}
                </p>

            </div>


            <div class="rounded-2xl bg-white
                        p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    Administrators
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalAdministrators }}
                </p>

            </div>


            <div class="rounded-2xl bg-white
                        p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    Total Pets
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalPets }}
                </p>

            </div>


            <div class="rounded-2xl bg-white
                        p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    Available Pets
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $availablePets }}
                </p>

            </div>

        </div>


        {{-- Application counts --}}
        <div class="mt-8">

            <h2 class="text-xl font-bold text-gray-900">
                Adoption Applications
            </h2>


            <div class="mt-4 grid gap-5 sm:grid-cols-3">

                <div class="rounded-2xl bg-white
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-gray-500">
                        Pending
                    </p>

                    <p class="mt-2 text-3xl font-bold text-yellow-600">
                        {{ $pendingApplications }}
                    </p>

                </div>


                <div class="rounded-2xl bg-white
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-gray-500">
                        Approved
                    </p>

                    <p class="mt-2 text-3xl font-bold text-green-600">
                        {{ $approvedApplications }}
                    </p>

                </div>


                <div class="rounded-2xl bg-white
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-gray-500">
                        Rejected
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-600">
                        {{ $rejectedApplications }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Recent activity --}}
        <div class="mt-8">

            <h2 class="text-xl font-bold text-gray-900">
                Recent Application Activity
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Latest adoption applications recorded
                in the system.
            </p>


            @if ($recentApplications->isEmpty())

                <div class="mt-4 rounded-2xl bg-white
                            p-6 shadow-sm">

                    <p class="text-gray-600">
                        No application activity yet.
                    </p>

                </div>

            @else

                <div class="mt-4 overflow-hidden
                            rounded-2xl bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="w-full text-left">

                            <thead class="bg-orange-50">

                                <tr>

                                    <th class="px-6 py-4">
                                        Adopter
                                    </th>

                                    <th class="px-6 py-4">
                                        Pet
                                    </th>

                                    <th class="px-6 py-4">
                                        Status
                                    </th>

                                    <th class="px-6 py-4">
                                        Date
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @foreach (
                                    $recentApplications
                                    as $application
                                )

                                    <tr>

                                        <td class="px-6 py-4
                                                   font-semibold">
                                            {{ $application->user->name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $application->pet->name }}
                                        </td>

                                        <td class="px-6 py-4">

                                            <span
                                                class="rounded-full
                                                       px-3 py-1
                                                       text-sm font-semibold
                                                @if ($application->status === 'Approved')
                                                    bg-green-100 text-green-700
                                                @elseif ($application->status === 'Rejected')
                                                    bg-red-100 text-red-700
                                                @else
                                                    bg-yellow-100 text-yellow-700
                                                @endif"
                                            >
                                                {{ $application->status }}
                                            </span>

                                        </td>

                                        <td class="px-6 py-4
                                                   text-gray-600">
                                            {{
                                                $application
                                                    ->created_at
                                                    ->format('M d, Y')
                                            }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif

        </div>

    </div>

</section>

@endsection