@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@php
    $chartData = [
        ['label' => 'Pending', 'count' => $pendingApplications, 'color' => 'bg-amber-400'],
        ['label' => 'Approved', 'count' => $approvedApplications, 'color' => 'bg-green-500'],
        ['label' => 'Rejected', 'count' => $rejectedApplications, 'color' => 'bg-red-400'],
    ];

    $chartMax = max(1, $pendingApplications, $approvedApplications, $rejectedApplications);
@endphp

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6">

        {{-- WELCOME HEADER --}}
        <div class="rounded-3xl bg-orange-500 p-6 text-white shadow-sm sm:p-8">

            <p class="text-sm font-semibold text-orange-100">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold">
                Admin Dashboard
            </h1>

            <p class="mt-2 max-w-2xl text-orange-50">
                Welcome back, {{ auth()->user()->name }}.
                Here's an overview of the shelter's adoption activities.
            </p>

            <p class="mt-4 text-sm text-orange-100">
                {{ now()->format('l, F d, Y') }}
            </p>

        </div>

        {{-- STATISTICS --}}
        <div>

            <h2 class="mb-4 text-xl font-bold text-gray-900">
                Shelter Overview
            </h2>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Pending Applications
                    </p>

                    <p class="mt-3 text-3xl font-bold text-amber-600">
                        {{ $pendingApplications }}
                    </p>

                    <a href="{{ route('admin.applications.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600">
                        Review Applications →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Available Pets
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $availablePets }}
                    </p>

                    <a href="{{ route('admin.pets.manage') }}"
                       class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600">
                        Manage Pets →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Registered Adopters
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalAdopters }}
                    </p>

                    <a href="{{ route('admin.adopters.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600">
                        View Adopters →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Pending Edit Requests
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $pendingEditRequests->count() }}
                    </p>

                    <p class="mt-4 text-sm text-gray-500">
                        Compatibility assessment requests
                    </p>
                </div>

            </div>
        </div>

        {{-- APPLICATION BAR GRAPH --}}
        <div class="grid gap-6 lg:grid-cols-3">

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            Adoption Application Statistics
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Current application status distribution
                        </p>
                    </div>

                    <span class="rounded-full bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">
                        All Time
                    </span>
                </div>

                <div class="mt-8 space-y-6">

                    @foreach ($chartData as $bar)

                        <div>

                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $bar['label'] }}
                                </span>

                                <span class="text-sm font-bold text-gray-900">
                                    {{ $bar['count'] }}
                                </span>
                            </div>

                            <div
                                class="h-7 overflow-hidden rounded-lg bg-gray-100"
                                role="progressbar"
                                aria-label="{{ $bar['label'] }} applications"
                                aria-valuenow="{{ $bar['count'] }}"
                                aria-valuemin="0"
                                aria-valuemax="{{ $chartMax }}"
                            >
                                <div
                                    class="h-full rounded-lg {{ $bar['color'] }}"
                                    @style([
                                        'width: ' . ($bar['count'] / $chartMax * 100) . '%'
                                    ])
                                ></div>
                            </div>

                        </div>

                    @endforeach

                </div>

                <p class="mt-6 text-xs text-gray-500">
                    Pending counts include applications with completed compatibility assessments.
                </p>

            </div>

            {{-- QUICK ACTIONS --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-bold text-gray-900">
                    Quick Actions
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Frequently used management tools
                </p>

                <div class="mt-5 space-y-3">

                    <a href="{{ route('admin.pets.manage') }}"
                       class="flex items-center justify-between rounded-xl bg-orange-50 px-4 py-3 font-semibold text-orange-700 hover:bg-orange-100">
                        <span>Manage Pets</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.applications.index') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>Review Applications</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.adopters.index') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>Registered Adopters</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.adoption-records.index') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>Adoption Records</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>Printable Reports</span>
                        <span>→</span>
                    </a>

                </div>

            </div>

        </div>

        {{-- PENDING EDIT REQUESTS --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Pending Compatibility Edit Requests
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Requests waiting for your review
                    </p>
                </div>

                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">
                    {{ $pendingEditRequests->count() }} Pending
                </span>

            </div>

            @if ($pendingEditRequests->isEmpty())

                <p class="mt-6 rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                    No pending edit requests at the moment.
                </p>

            @else

                <div class="mt-5 overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="border-b bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Adopter</th>
                                <th class="px-4 py-3">Last Updated</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($pendingEditRequests as $profile)
                                <tr>
                                    <td class="px-4 py-4 font-semibold text-gray-900">
                                        {{ $profile->user->name }}
                                    </td>

                                    <td class="px-4 py-4 text-gray-600">
                                        {{ $profile->updated_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <span class="rounded-full bg-amber-100 px-3 py-1 font-semibold text-amber-700">
                                            Pending
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-right">
                                        <a href="{{ route('admin.adopters.show', $profile->user) }}"
                                           class="font-semibold text-orange-500 hover:text-orange-600">
                                            Review Request →
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
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Applications Needing Review
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Five most recent pending applications
                    </p>
                </div>

                <a href="{{ route('admin.applications.index') }}"
                   class="text-sm font-semibold text-orange-500 hover:text-orange-600">
                    View All →
                </a>

            </div>

            @if ($recentPendingApplications->isEmpty())

                <p class="mt-6 rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                    No applications currently need review.
                </p>

            @else

                <div class="mt-5 overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="border-b bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Adopter</th>
                                <th class="px-4 py-3">Pet</th>
                                <th class="px-4 py-3">Submitted</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($recentPendingApplications as $application)
                                <tr>
                                    <td class="px-4 py-4 font-semibold text-gray-900">
                                        {{ $application->user?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $application->pet?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-4 text-gray-600">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-4 py-4 text-right">
                                        <a href="{{ route('admin.applications.show', $application) }}"
                                           class="font-semibold text-orange-500 hover:text-orange-600">
                                            Review →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</section>

@endsection