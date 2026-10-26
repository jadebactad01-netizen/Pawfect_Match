@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6">

        {{-- WELCOME --}}
        <div class="rounded-3xl bg-orange-500 p-6 text-white shadow-sm sm:p-8">

            <p class="text-sm font-semibold text-orange-100">
                My Adoption Journey
            </p>

            <h1 class="mt-2 text-3xl font-bold">
                Welcome, {{ auth()->user()->name }}!
            </h1>

            <p class="mt-3 max-w-2xl text-orange-50">
                Find your pawfect companion, track your applications,
                and discover pets that match your lifestyle.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">

                <a href="{{ route('pets.index') }}"
                   class="rounded-full bg-white px-5 py-3 text-sm font-bold text-orange-600 hover:bg-orange-50">
                    Browse Available Pets
                </a>

                <a href="{{ route('adoption-applications.index') }}"
                   class="rounded-full border border-white px-5 py-3 text-sm font-bold text-white hover:bg-orange-600">
                    My Applications
                </a>

            </div>

        </div>

        {{-- APPLICATION OVERVIEW --}}
        <div>

            <h2 class="mb-4 text-xl font-bold text-gray-900">
                Application Overview
            </h2>

            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Total Applications
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $applications->count() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Pending
                    </p>

                    <p class="mt-3 text-3xl font-bold text-amber-600">
                        {{ $pendingApplications }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Approved
                    </p>

                    <p class="mt-3 text-3xl font-bold text-green-600">
                        {{ $approvedApplications }}
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Rejected
                    </p>

                    <p class="mt-3 text-3xl font-bold text-red-600">
                        {{ $rejectedApplications }}
                    </p>
                </div>

            </div>

        </div>

        {{-- LATEST APPLICATION AND SHORTCUTS --}}
        <div class="grid gap-6 lg:grid-cols-3">

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">

                <div class="flex flex-wrap items-center justify-between gap-3">

                    <h2 class="text-xl font-bold text-gray-900">
                        Latest Application
                    </h2>

                    <a href="{{ route('adoption-applications.index') }}"
                       class="text-sm font-semibold text-orange-500 hover:text-orange-600">
                        View All →
                    </a>

                </div>

                @if ($latestApplication)

                    <div class="mt-6 flex flex-col gap-5 sm:flex-row">

                        @if ($latestApplication->pet?->photo)

                            <img
                                src="{{ asset('storage/' . $latestApplication->pet->photo) }}"
                                alt="{{ $latestApplication->pet->name }}"
                                class="h-40 w-full rounded-2xl object-cover sm:w-40"
                            >

                        @else

                            <div class="flex h-40 w-full items-center justify-center rounded-2xl bg-orange-50 text-sm text-gray-400 sm:w-40">
                                No photo available
                            </div>

                        @endif

                        <div class="flex-1">

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Pet Applied For
                            </p>

                            <h3 class="mt-2 text-2xl font-bold text-gray-900">
                                {{ $latestApplication->pet?->name ?? 'Pet unavailable' }}
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                Submitted {{ $latestApplication->created_at->format('M d, Y') }}
                            </p>

                            <div class="mt-4">

                                <span class="rounded-full px-3 py-1 text-sm font-semibold
                                    @if ($latestApplication->status === 'Approved')
                                        bg-green-100 text-green-700
                                    @elseif ($latestApplication->status === 'Rejected')
                                        bg-red-100 text-red-700
                                    @else
                                        bg-amber-100 text-amber-700
                                    @endif">
                                    {{ $latestApplication->status }}
                                </span>

                            </div>

                            @if ($latestApplication->compatibilityAssessment)

                                <p class="mt-5 text-sm text-gray-600">
                                    Compatibility Score:
                                    <span class="font-bold text-gray-900">
                                        {{ $latestApplication->compatibilityAssessment->total_score }}%
                                    </span>
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $latestApplication->compatibilityAssessment->classification }}
                                </p>

                            @else

                                <a
                                    href="{{ route('compatibility-assessments.create', $latestApplication) }}"
                                    class="mt-5 inline-block font-semibold text-orange-500 hover:text-orange-600"
                                >
                                    Complete Compatibility Assessment →
                                </a>

                            @endif

                        </div>

                    </div>

                @else

                    <div class="mt-6 rounded-2xl bg-orange-50 p-6">

                        <h3 class="text-lg font-bold text-gray-900">
                            Your adoption journey starts here!
                        </h3>

                        <p class="mt-2 text-sm text-gray-600">
                            You haven't submitted an application yet.
                            Browse available pets and find your perfect companion.
                        </p>

                        <a href="{{ route('pets.index') }}"
                           class="mt-4 inline-block rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                            Find a Pet →
                        </a>

                    </div>

                @endif

            </div>

            {{-- QUICK LINKS --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-bold text-gray-900">
                    Quick Links
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Everything you need in one place
                </p>

                <div class="mt-5 space-y-3">

                    <a href="{{ route('pets.index') }}"
                       class="flex items-center justify-between rounded-xl bg-orange-50 px-4 py-3 font-semibold text-orange-700 hover:bg-orange-100">
                        <span>Find a Pet</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('adoption-applications.index') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>My Applications</span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                        <span>My Profile</span>
                        <span>→</span>
                    </a>

                </div>

            </div>

        </div>

        {{-- RECOMMENDED PETS --}}
        @if ($recommendedPets->isNotEmpty())

            <div>

                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-900">
                        Recommended for You
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Suggested pets based on your latest compatibility assessment
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($recommendedPets as $recommendation)

                        <a
                            href="{{ route('pets.show', $recommendation->pet) }}"
                            class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                        >

                            @if ($recommendation->pet->photo)

                                <img
                                    src="{{ asset('storage/' . $recommendation->pet->photo) }}"
                                    alt="{{ $recommendation->pet->name }}"
                                    class="h-44 w-full object-cover"
                                >

                            @else

                                <div class="flex h-44 items-center justify-center bg-orange-50 text-sm text-gray-400">
                                    No photo available
                                </div>

                            @endif

                            <div class="p-5">

                                <div class="flex items-start justify-between gap-3">

                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $recommendation->pet->name }}
                                    </h3>

                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                        {{ $recommendation->compatibility_score }}%
                                    </span>

                                </div>

                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $recommendation->pet->type }}
                                    • {{ $recommendation->pet->sex }}
                                    • {{ $recommendation->pet->age }}
                                </p>

                                <p class="mt-3 text-sm font-medium text-orange-600">
                                    {{ $recommendation->classification }}
                                </p>

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        @endif

        {{-- AVAILABLE PETS --}}
        <div>

            <div class="mb-4 flex flex-wrap items-end justify-between gap-3">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Meet Available Pets
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        These pets are currently looking for a loving home
                    </p>
                </div>

                <a href="{{ route('pets.index') }}"
                   class="text-sm font-semibold text-orange-500 hover:text-orange-600">
                    View All Pets →
                </a>

            </div>

            @if ($availablePets->isEmpty())

                <div class="rounded-2xl bg-white p-8 text-center text-gray-500 shadow-sm">
                    No pets are currently available for adoption.
                </div>

            @else

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($availablePets as $pet)

                        <a
                            href="{{ route('pets.show', $pet) }}"
                            class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                        >

                            @if ($pet->photo)

                                <img
                                    src="{{ asset('storage/' . $pet->photo) }}"
                                    alt="{{ $pet->name }}"
                                    class="h-44 w-full object-cover"
                                >

                            @else

                                <div class="flex h-44 items-center justify-center bg-orange-50 text-sm text-gray-400">
                                    No photo available
                                </div>

                            @endif

                            <div class="p-5">

                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $pet->name }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $pet->type }}
                                    • {{ $pet->sex }}
                                    • {{ $pet->age }}
                                </p>

                                <span class="mt-4 inline-block text-sm font-semibold text-orange-500">
                                    View Pet Details →
                                </span>

                            </div>

                        </a>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</section>

@endsection