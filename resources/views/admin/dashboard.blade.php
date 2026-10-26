@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl px-6">

        {{-- HEADING --}}
        <div>
            <p class="font-semibold text-orange-500">
                Administration
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Admin Dashboard
            </h1>

            <p class="mt-2 text-gray-600">
                Manage the shelter's current adoption activities.
            </p>
        </div>

        {{-- DASHBOARD COUNTS --}}
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-gray-500">
                    Pending Applications
                </p>

                <p class="mt-2 text-3xl font-bold text-yellow-600">
                    {{ $pendingApplications }}
                </p>

                <a
                    href="{{ route('admin.applications.index') }}"
                    class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600"
                >
                    View Applications →
                </a>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-gray-500">
                    Available Pets
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $availablePets }}
                </p>

                <a
                    href="{{ route('admin.pets.manage') }}"
                    class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600"
                >
                    Manage Pets →
                </a>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-gray-500">
                    Registered Adopters
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalAdopters }}
                </p>

                <a
                    href="{{ route('admin.adopters.index') }}"
                    class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600"
                >
                    View Adopters →
                </a>
            </div>

        </div>

        {{-- COMPATIBILITY EDIT REQUESTS --}}
        <div class="mt-10">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Pending Compatibility Edit Requests
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Adopters requesting permission to update their compatibility assessment.
                    </p>
                </div>

                <span class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-800">
                    {{ $pendingEditRequests->count() }} Pending
                </span>
            </div>

            @if ($pendingEditRequests->isEmpty())

                <div class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-gray-600">
                        There are no pending compatibility edit requests.
                    </p>
                </div>

            @else

                <div class="mt-4 overflow-x-auto rounded-2xl bg-white shadow-sm">
                    <table class="w-full text-left">

                        <thead class="bg-orange-50">
                            <tr>
                                <th class="px-6 py-4">Adopter</th>
                                <th class="px-6 py-4">Date Requested</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($pendingEditRequests as $profile)

                                <tr>
                                    <td class="px-6 py-4 font-semibold">
                                        {{ $profile->user->name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $profile->updated_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-800">
                                            Pending
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href="{{ route('admin.adopters.show', $profile->user) }}"
                                            class="font-semibold text-orange-500 hover:text-orange-600"
                                        >
                                            Review Request
                                        </a>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

            @endif
        </div>

        {{-- APPLICATIONS NEEDING REVIEW --}}
        <div class="mt-10">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Applications Needing Review
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Most recent pending adoption applications.
                    </p>
                </div>

                <a
                    href="{{ route('admin.applications.index') }}"
                    class="text-sm font-semibold text-orange-500 hover:text-orange-600"
                >
                    View All Applications
                </a>
            </div>

            @if ($recentPendingApplications->isEmpty())

                <div class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-gray-600">
                        There are no pending applications requiring review.
                    </p>
                </div>

            @else

                <div class="mt-4 overflow-x-auto rounded-2xl bg-white shadow-sm">

                    <table class="w-full text-left">

                        <thead class="bg-orange-50">
                            <tr>
                                <th class="px-6 py-4">Adopter</th>
                                <th class="px-6 py-4">Pet</th>
                                <th class="px-6 py-4">Date Submitted</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($recentPendingApplications as $application)

                                <tr>
                                    <td class="px-6 py-4 font-semibold">
                                        {{ $application->user->name }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $application->pet->name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href="{{ route('admin.applications.show', $application) }}"
                                            class="font-semibold text-orange-500 hover:text-orange-600"
                                        >
                                            Review
                                        </a>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>

                </div>

            @endif

        </div>

        {{-- QUICK ACTIONS --}}
        <div class="mt-10">

            <h2 class="text-xl font-bold text-gray-900">
                Quick Actions
            </h2>

            <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <a
                    href="{{ route('admin.pets.manage') }}"
                    class="rounded-2xl bg-white p-5 shadow-sm transition hover:shadow-md"
                >
                    <p class="font-bold text-gray-900">
                        Manage Pets
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        Add, edit, or update pet information.
                    </p>
                </a>

                <a
                    href="{{ route('admin.applications.index') }}"
                    class="rounded-2xl bg-white p-5 shadow-sm transition hover:shadow-md"
                >
                    <p class="font-bold text-gray-900">
                        Review Applications
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        Review pending adoption applications.
                    </p>
                </a>

                <a
                    href="{{ route('admin.adoption-records.index') }}"
                    class="rounded-2xl bg-white p-5 shadow-sm transition hover:shadow-md"
                >
                    <p class="font-bold text-gray-900">
                        Adoption Records
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        View completed application decisions.
                    </p>
                </a>

                {{-- NEW REPORTS SHORTCUT --}}
                <a
                    href="{{ route('admin.reports.index') }}"
                    class="rounded-2xl bg-white p-5 shadow-sm transition hover:shadow-md"
                >
                    <p class="font-bold text-gray-900">
                        Printable Reports
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        Generate, print, or save shelter reports as PDF.
                    </p>
                </a>

            </div>
        </div>

    </div>

</section>

@endsection