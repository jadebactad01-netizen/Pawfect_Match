@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

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

        {{-- WELCOME --}}
        <div class="rounded-3xl bg-orange-500 p-6 text-white shadow-sm sm:p-8">

            <p class="text-sm font-semibold text-orange-100">
                System Administration
            </p>

            <h1 class="mt-2 text-3xl font-bold">
                Super Admin Dashboard
            </h1>

            <p class="mt-2 max-w-2xl text-orange-50">
                Welcome back, {{ auth()->user()->name }}.
                Monitor your shelter's operations and manage the Pawfect Match system.
            </p>

            <p class="mt-4 text-sm text-orange-100">
                {{ now()->format('l, F d, Y') }}
            </p>

        </div>

        {{-- SYSTEM STATISTICS --}}
        <div>

            <h2 class="mb-4 text-xl font-bold text-gray-900">
                System Overview
            </h2>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

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
                        Administrators
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalAdministrators }}
                    </p>

                    <a href="{{ route('super-admin.administrators.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600">
                        Manage Accounts →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Total Pets
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalPets }}
                    </p>

                    <a href="{{ route('admin.pets.manage') }}"
                       class="mt-4 inline-block text-sm font-semibold text-orange-500 hover:text-orange-600">
                        Manage Pets →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Available Pets
                    </p>

                    <p class="mt-3 text-3xl font-bold text-green-600">
                        {{ $availablePets }}
                    </p>

                    <p class="mt-4 text-sm text-gray-500">
                        Currently available for adoption
                    </p>
                </div>

            </div>

        </div>

        {{-- CHART AND QUICK ACTIONS --}}
        <div class="grid gap-6 lg:grid-cols-3">

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">

                <div class="flex flex-wrap items-center justify-between gap-3">

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            Adoption Application Statistics
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            System-wide application status distribution
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

                <div class="mt-7 grid grid-cols-3 gap-3 border-t border-gray-100 pt-5 text-center">

                    <div>
                        <p class="text-2xl font-bold text-amber-600">
                            {{ $pendingApplications }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Pending</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $approvedApplications }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Approved</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold text-red-600">
                            {{ $rejectedApplications }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Rejected</p>
                    </div>

                </div>

            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-bold text-gray-900">
                    Quick Actions
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    System management shortcuts
                </p>

                <div class="mt-5 space-y-3">

                    <a href="{{ route('super-admin.administrators.index') }}"
                       class="flex items-center justify-between rounded-xl bg-orange-50 px-4 py-3 font-semibold text-orange-700 hover:bg-orange-100">
                        <span>Manage Administrators</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.pets.manage') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>Manage Pets</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('admin.applications.index') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>Review Applications</span>
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
                        Assessment edit requests waiting for approval
                    </p>
                </div>

                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">
                    {{ $pendingEditRequests->count() }} Pending
                </span>

            </div>

            @if ($pendingEditRequests->isEmpty())

                <p class="mt-6 rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                    No pending assessment edit requests.
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

        {{-- RECENT APPLICATIONS --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Recent Application Activity
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Latest adoption applications in the system
                    </p>
                </div>

                <a href="{{ route('admin.reports.index', ['type' => 'applications']) }}"
                   class="text-sm font-semibold text-orange-500 hover:text-orange-600">
                    Full Report →
                </a>

            </div>

            @if ($recentApplications->isEmpty())

                <p class="mt-6 rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                    No application activity recorded yet.
                </p>

            @else

                <div class="mt-5 overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="border-b bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Adopter</th>
                                <th class="px-4 py-3">Pet</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Submitted</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($recentApplications as $application)

                                <tr>
                                    <td class="px-4 py-4 font-semibold text-gray-900">
                                        {{ $application->user?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $application->pet?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                                            @if ($application->status === 'Approved')
                                                bg-green-100 text-green-700
                                            @elseif ($application->status === 'Rejected')
                                                bg-red-100 text-red-700
                                            @else
                                                bg-amber-100 text-amber-700
                                            @endif">
                                            {{ $application->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-gray-600">
                                        {{ $application->created_at->format('M d, Y') }}
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