
@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')

@php
    $chartData = [
        ['label' => 'Pending', 'count' => $chartPending, 'color' => 'bg-amber-400'],
        ['label' => 'Approved', 'count' => $chartApproved, 'color' => 'bg-green-500'],
        ['label' => 'Rejected', 'count' => $chartRejected, 'color' => 'bg-red-400'],
    ];

    $chartMax = max(1, $chartPending, $chartApproved, $chartRejected);
    $monthlyMax = max(1, max(array_column($monthlyApplications, 'count')));
    $monthlyTotal = array_sum(array_column($monthlyApplications, 'count'));
@endphp

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6">

        {{-- WELCOME HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-500 p-6 text-white shadow-sm sm:p-8">

            <p class="text-sm font-semibold uppercase tracking-wider text-orange-100">
                System Administration
            </p>

            <h1 class="mt-2 text-3xl font-bold">
                Super Admin Dashboard
            </h1>

            <p class="mt-3 max-w-2xl leading-7 text-orange-50">
                Welcome back, {{ auth()->user()->name }}.
                Monitor your shelter's operations and manage the Pawfect Match system.
            </p>

            <p class="mt-4 text-sm font-medium text-orange-100">
                {{ now()->format('l, F d, Y') }}
            </p>

        </div>

        {{-- SYSTEM OVERVIEW --}}
        <div>

            <div class="mb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Dashboard Overview
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    System Overview
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    A quick summary of the shelter's current activities.
                </p>

            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- 1. PENDING APPLICATIONS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-amber-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Pending Applications
                    </p>

                    <p class="mt-3 text-3xl font-bold text-amber-600">
                        {{ $pendingApplications }}
                    </p>

                    <a
                        href="{{ route('admin.applications.index') }}"
                        class="mt-auto block pt-5 text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        Review Applications →
                    </a>

                </div>

                {{-- 2. AVAILABLE PETS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-orange-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Available Pets
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $availablePets }}
                    </p>

                    <a
                        href="{{ route('admin.pets.manage') }}"
                        class="mt-auto block pt-5 text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        Manage Pets →
                    </a>

                </div>

                {{-- 3. REGISTERED ADOPTERS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-green-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Registered Adopters
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalAdopters }}
                    </p>

                    <a
                        href="{{ route('admin.adopters.index') }}"
                        class="mt-auto block pt-5 text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        View Adopters →
                    </a>

                </div>

                {{-- 4. ACCOUNT APPROVALS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-blue-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Account Approvals
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $pendingAccountApprovals }}
                    </p>

                    <a
                        href="{{ route('admin.account-approvals.index') }}"
                        class="mt-auto block pt-5 text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        View Account Approvals →
                    </a>

                </div>

                {{-- 5. PENDING EDIT REQUESTS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-purple-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Pending Edit Requests
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $pendingEditRequests->count() }}
                    </p>

                    <a
                        href="#pending-edit-requests"
                        class="mt-auto block pt-5 text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        View Requests ↓
                    </a>

                </div>

                {{-- 6. ADMINISTRATORS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-blue-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Administrators
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalAdministrators }}
                    </p>

                    <a
                        href="{{ route('super-admin.administrators.index') }}"
                        class="mt-auto block pt-5 text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        Manage Accounts →
                    </a>

                </div>

                {{-- 7. TOTAL PETS --}}
                <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-orange-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Pets
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalPets }}
                    </p>

                </div>

            </div>

        </div>

        {{-- APPLICATION STATISTICS AND RECENT SHELTER ACTIVITY --}}
        <div class="grid items-stretch gap-6 lg:grid-cols-3">

            {{-- ADOPTION APPLICATION STATISTICS --}}
            <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">

                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">

                    <div class="xl:w-[44%]">

                        <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                            Application Insights
                        </p>

                        <h2 class="mt-1 text-xl font-bold leading-snug text-gray-900">
                            Adoption Application Statistics
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Current application status distribution
                        </p>

                    </div>

                    {{-- DATE FILTER --}}
                    <form
                        action="{{ route('super-admin.dashboard') }}"
                        method="GET"
                        class="w-full xl:w-[56%]"
                    >

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <div>

                                <label
                                    for="date_from"
                                    class="mb-1 block text-xs font-semibold text-gray-600"
                                >
                                    From Date
                                </label>

                                <input
                                    type="date"
                                    id="date_from"
                                    name="date_from"
                                    value="{{ $dateFrom }}"
                                    class="w-full min-w-0 rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >

                            </div>

                            <div>

                                <label
                                    for="date_to"
                                    class="mb-1 block text-xs font-semibold text-gray-600"
                                >
                                    To Date
                                </label>

                                <input
                                    type="date"
                                    id="date_to"
                                    name="date_to"
                                    value="{{ $dateTo }}"
                                    min="{{ $dateFrom }}"
                                    class="w-full min-w-0 rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >

                            </div>

                        </div>

                        @error('date_from')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('date_to')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="mt-3 flex flex-wrap items-center gap-2">

                            <button
                                type="submit"
                                class="rounded-full bg-orange-500 px-5 py-2 text-xs font-semibold text-white hover:bg-orange-600"
                            >
                                Filter
                            </button>

                            <a
                                href="{{ route('super-admin.dashboard') }}"
                                class="rounded-full border border-orange-200 bg-white px-5 py-2 text-xs font-semibold text-gray-600 hover:bg-orange-50"
                            >
                                Reset
                            </a>

                        </div>

                    </form>

                </div>

                {{-- STATUS GRAPH --}}
                <div class="mt-6 flex flex-1 flex-col justify-center space-y-5">

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
                                class="h-5 overflow-hidden rounded-lg bg-orange-50"
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

                @if ($chartPending + $chartApproved + $chartRejected === 0)

                    <p class="mt-4 rounded-xl border border-orange-100 bg-orange-50/50 p-3 text-center text-sm text-gray-500">
                        No applications found for the selected date range.
                    </p>

                @endif

                <p class="mt-5 text-xs text-gray-500">
                    Pending counts include applications with completed compatibility assessments.
                </p>

            </div>

            {{-- RECENT SHELTER ACTIVITY --}}
            <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Shelter Updates
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Recent Shelter Activity
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Latest updates from the shelter
                </p>

                @if ($recentActivities->isEmpty())

                    <div class="mt-5 rounded-xl border border-orange-100 bg-orange-50/50 p-4">

                        <p class="text-sm text-gray-500">
                            No recent shelter activity available.
                        </p>

                    </div>

                @else

                    <div class="mt-4 flex flex-1 flex-col justify-around gap-2">

                        @foreach ($recentActivities as $activity)

                            <a
                                href="{{ $activity['link'] }}"
                                class="flex items-start gap-3 rounded-xl border border-orange-100 bg-orange-50/40 p-3 transition hover:border-orange-200 hover:bg-orange-50"
                            >

                                <div class="mt-1 h-3 w-3 shrink-0 rounded-full
                                    @if ($activity['color'] === 'green')
                                        bg-green-400
                                    @elseif ($activity['color'] === 'red')
                                        bg-red-400
                                    @elseif ($activity['color'] === 'amber')
                                        bg-amber-400
                                    @else
                                        bg-orange-400
                                    @endif"
                                ></div>

                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $activity['title'] }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-gray-600">
                                        {{ $activity['description'] }}
                                    </p>

                                </div>

                            </a>

                        @endforeach

                    </div>

                @endif

            </div>

        </div>

        {{-- MONTHLY ADOPTION APPLICATIONS --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Monthly Insights
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Monthly Adoption Applications
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Number of adoption applications submitted each month
                    </p>

                </div>

                <span class="rounded-full border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">
                    Last 12 Months
                </span>

            </div>

            <div class="mt-8 overflow-x-auto pb-2">

                <div class="flex min-w-[620px] items-end gap-3">

                    @foreach ($monthlyApplications as $month)

                        <div class="flex min-w-0 flex-1 flex-col items-center">

                            <span class="mb-2 text-xs font-bold text-gray-700">
                                {{ $month['count'] }}
                            </span>

                            <div class="flex h-44 w-full items-end justify-center rounded-lg bg-orange-50/60 px-1">

                                <div
                                    class="w-full max-w-10 rounded-t-md bg-orange-400"
                                    @style([
                                        'height: ' . ($month['count'] / $monthlyMax * 100) . '%'
                                    ])
                                    title="{{ $month['label'] }} {{ $month['year'] }}: {{ $month['count'] }} applications"
                                ></div>

                            </div>

                            <span class="mt-3 text-xs font-semibold text-gray-700">
                                {{ $month['label'] }}
                            </span>

                            <span class="mt-1 text-xs text-gray-400">
                                {{ $month['year'] }}
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

            <div class="mt-6 border-t border-orange-100 pt-4">

                <p class="text-sm text-gray-600">

                    <span class="font-bold text-orange-600">
                        {{ $monthlyTotal }}
                    </span>

                    applications submitted in the last 12 calendar months.

                </p>

                <p class="mt-2 text-xs text-gray-500">
                    Includes all application statuses. This graph is independent
                    of the status graph's date filter.
                </p>

            </div>

        </div>

        {{-- PENDING COMPATIBILITY EDIT REQUESTS --}}
        <div
            id="pending-edit-requests"
            class="scroll-mt-6 rounded-2xl border border-orange-100 bg-white p-6 shadow-sm"
        >

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Adopter Requests
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Pending Compatibility Edit Requests
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Requests waiting for your review
                    </p>

                </div>

                <span class="rounded-full border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                    {{ $pendingEditRequests->count() }} Pending
                </span>

            </div>

            @if ($pendingEditRequests->isEmpty())

                <p class="mt-6 rounded-xl border border-orange-100 bg-orange-50/50 p-5 text-sm text-gray-500">
                    No pending assessment edit requests.
                </p>

            @else

                <div class="mt-5 overflow-x-auto rounded-xl border border-orange-100">

                    <table class="min-w-full text-left text-sm">

                        <thead class="border-b border-orange-100 bg-orange-50/70 text-gray-700">

                            <tr>
                                <th class="px-4 py-3 font-semibold">Adopter</th>
                                <th class="px-4 py-3 font-semibold">Last Updated</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                                <th class="px-4 py-3 text-right font-semibold">Action</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-orange-100">

                            @foreach ($pendingEditRequests as $profile)

                                <tr class="hover:bg-orange-50/40">

                                    <td class="px-4 py-4 font-semibold text-gray-900">
                                        {{ $profile->user->name }}
                                    </td>

                                    <td class="px-4 py-4 text-gray-600">
                                        {{ $profile->updated_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-4 py-4">

                                        <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Pending
                                        </span>

                                    </td>

                                    <td class="px-4 py-4 text-right">

                                        <a
                                            href="{{ route('admin.adopters.show', $profile->user) }}"
                                            class="font-semibold text-orange-600 hover:text-orange-700"
                                        >
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

        {{-- RECENT APPLICATION ACTIVITY --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Application Management
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Recent Application Activity
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Latest adoption applications in the system
                    </p>

                </div>

                <a
                    href="{{ route('admin.reports.index', ['type' => 'applications']) }}"
                    class="text-sm font-semibold text-orange-600 hover:text-orange-700"
                >
                    Full Report →
                </a>

            </div>

            @if ($recentApplications->isEmpty())

                <p class="mt-6 rounded-xl border border-orange-100 bg-orange-50/50 p-5 text-sm text-gray-500">
                    No application activity recorded yet.
                </p>

            @else

                <div class="mt-5 overflow-x-auto rounded-xl border border-orange-100">

                    <table class="min-w-full text-left text-sm">

                        <thead class="border-b border-orange-100 bg-orange-50/70 text-gray-700">

                            <tr>
                                <th class="px-4 py-3 font-semibold">Adopter</th>
                                <th class="px-4 py-3 font-semibold">Pet</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                                <th class="px-4 py-3 font-semibold">Submitted</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-orange-100">

                            @foreach ($recentApplications as $application)

                                <tr class="hover:bg-orange-50/40">

                                    <td class="px-4 py-4 font-semibold text-gray-900">
                                        {{ $application->user?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-4 text-gray-700">
                                        {{ $application->pet?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-4">

                                        <span class="rounded-full border px-3 py-1 text-xs font-semibold
                                            @if ($application->status === 'Approved')
                                                border-green-200 bg-green-50 text-green-700
                                            @elseif ($application->status === 'Rejected')
                                                border-red-200 bg-red-50 text-red-700
                                            @else
                                                border-amber-200 bg-amber-50 text-amber-700
                                            @endif"
                                        >
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
