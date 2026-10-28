@extends('layouts.app')

@section('title', 'My Dashboard - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6">

        {{-- WELCOME SECTION --}}
        <div class="relative overflow-hidden rounded-3xl border border-orange-200 bg-gradient-to-r from-orange-500 to-orange-400 p-6 text-white shadow-sm sm:p-8">

            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border-[25px] border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-20 right-24 h-36 w-36 rounded-full bg-white/10"></div>

            <div class="relative">

                <p class="text-sm font-semibold tracking-wide text-orange-100">
                    MY ADOPTION JOURNEY
                </p>

                <h1 class="mt-2 text-3xl font-bold">
                    Welcome, {{ auth()->user()->name }}!
                </h1>

                <p class="mt-3 max-w-2xl leading-7 text-orange-50">
                    Find your pawfect companion, track your applications,
                    and discover pets that match your lifestyle.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">

                    <a
                        href="{{ route('pets.index') }}"
                        class="rounded-full bg-white px-5 py-3 text-sm font-bold text-orange-600 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-orange-50 hover:shadow-md"
                    >
                        Browse Available Pets
                    </a>

                    <a
                        href="{{ route('adoption-applications.index') }}"
                        class="rounded-full border border-white/80 bg-white/10 px-5 py-3 text-sm font-bold text-white transition duration-200 hover:bg-white/20"
                    >
                        My Applications
                    </a>

                </div>

            </div>

        </div>

        {{-- APPLICATION OVERVIEW --}}
        <div>

            <div class="mb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Your Activity
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Application Overview
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Keep track of your adoption applications.
                </p>

            </div>

            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

                {{-- TOTAL --}}
                <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-orange-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Applications
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $applications->count() }}
                    </p>

                </div>

                {{-- PENDING --}}
                <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-amber-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Pending
                    </p>

                    <p class="mt-3 text-3xl font-bold text-amber-600">
                        {{ $pendingApplications }}
                    </p>

                </div>

                {{-- APPROVED --}}
                <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-green-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Approved
                    </p>

                    <p class="mt-3 text-3xl font-bold text-green-600">
                        {{ $approvedApplications }}
                    </p>

                </div>

                {{-- REJECTED --}}
                <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

                    <div class="mb-4 h-1 w-12 rounded-full bg-red-400"></div>

                    <p class="text-sm font-medium text-gray-500">
                        Rejected
                    </p>

                    <p class="mt-3 text-3xl font-bold text-red-600">
                        {{ $rejectedApplications }}
                    </p>

                </div>

            </div>

        </div>

        {{-- LATEST APPLICATION AND ADOPTION JOURNEY --}}
        <div class="grid items-stretch gap-6 lg:grid-cols-3">

            {{-- LATEST APPLICATION --}}
            <div class="flex flex-col rounded-2xl border border-orange-100 bg-white p-6 shadow-sm lg:col-span-2">

                <div class="flex flex-wrap items-center justify-between gap-3">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                            Adoption Progress
                        </p>

                        <h2 class="mt-1 text-xl font-bold text-gray-900">
                            Latest Application
                        </h2>

                    </div>

                    <a
                        href="{{ route('adoption-applications.index') }}"
                        class="text-sm font-semibold text-orange-600 transition hover:text-orange-700"
                    >
                        View All →
                    </a>

                </div>

                @if ($latestApplication)

                    {{-- BALANCED APPLICATION CARD --}}
                    <div class="mt-5 flex flex-1 flex-col justify-center gap-5 rounded-2xl border border-orange-100 bg-orange-50/50 p-4 sm:flex-row sm:items-center">

                        {{-- PET PHOTO --}}
                        @if ($latestApplication->pet?->photo)

                            <img
                                src="{{ asset('storage/' . $latestApplication->pet->photo) }}"
                                alt="{{ $latestApplication->pet->name }}"
                                class="h-44 w-full shrink-0 rounded-xl object-cover sm:w-44"
                            >

                        @else

                            <div class="flex h-44 w-full shrink-0 items-center justify-center rounded-xl bg-orange-100 text-sm text-gray-500 sm:w-44">
                                No photo available
                            </div>

                        @endif

                            {{-- APPLICATION DETAILS --}}
                            <div class="flex min-w-0 flex-1 flex-col gap-5 md:flex-row md:items-center md:gap-28">

                                {{-- PET INFORMATION --}}
                                <div class="min-w-0">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-orange-500">
                                        Pet Applied For
                                    </p>

                                    <h3 class="mt-2 text-2xl font-bold text-gray-900">
                                        {{ $latestApplication->pet?->name ?? 'Pet unavailable' }}
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Submitted {{ $latestApplication->created_at->format('M d, Y') }}
                                    </p>

                                    <div class="mt-4">

                                        <span class="rounded-full border px-3 py-1 text-sm font-semibold
                                            @if ($latestApplication->status === 'Approved')
                                                border-green-200 bg-green-50 text-green-700
                                            @elseif ($latestApplication->status === 'Rejected')
                                                border-red-200 bg-red-50 text-red-700
                                            @else
                                                border-amber-200 bg-amber-50 text-amber-700
                                            @endif"
                                        >
                                            {{ $latestApplication->status }}
                                        </span>

                                    </div>

                                </div>

                                {{-- COMPATIBILITY INFORMATION --}}
                                @if ($latestApplication->compatibilityAssessment)

                                    <div class="shrink-0 border-t border-orange-200 pt-4 md:ml-2 md:border-l md:border-t-0 md:py-3 md:pl-5">

                                        <p class="text-sm text-gray-500">
                                            Compatibility Score
                                        </p>

                                        <p class="mt-1 text-xl font-bold text-orange-600">
                                            {{ $latestApplication->compatibilityAssessment->total_score }}%
                                        </p>

                                        <p class="mt-2 text-sm font-semibold text-green-700">
                                            {{ $latestApplication->compatibilityAssessment->classification }}
                                        </p>

                                    </div>

                                @else

                                    <a
                                        href="{{ route('compatibility-assessments.create', $latestApplication) }}"
                                        class="text-sm font-semibold text-orange-600 transition hover:text-orange-700"
                                    >
                                        Complete Compatibility Assessment →
                                    </a>

                                @endif

                            </div>

                    </div>

                @else

                    {{-- NO APPLICATION YET --}}
                    <div class="mt-6 rounded-2xl border border-orange-100 bg-orange-50 p-6">

                        <div class="mb-4 h-1 w-12 rounded-full bg-orange-400"></div>

                        <h3 class="text-lg font-bold text-gray-900">
                            Your adoption journey starts here!
                        </h3>

                        <p class="mt-2 text-sm leading-7 text-gray-600">
                            You haven't submitted an application yet.
                            Browse available pets and find your perfect companion.
                        </p>

                        <a
                            href="{{ route('pets.index') }}"
                            class="mt-4 inline-block rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-orange-600 hover:shadow-md"
                        >
                            Find a Pet →
                        </a>

                    </div>

                @endif

            </div>

            {{-- YOUR ADOPTION JOURNEY --}}
            <div class="flex h-full flex-col rounded-2xl border border-orange-100 bg-white p-6 shadow-sm">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Your Progress
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Your Adoption Journey
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Follow your latest application's progress.
                    </p>

                </div>

                <div class="mt-4 flex flex-1 flex-col justify-around gap-3">

                    {{-- STEP 1 --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold
                            {{ $latestApplication
                                ? 'bg-green-100 text-green-700'
                                : 'bg-gray-100 text-gray-400' }}"
                        >
                            @if ($latestApplication)
                                &#10003;
                            @else
                                1
                            @endif
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-gray-900">
                                Application Submitted
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                {{ $latestApplication
                                    ? 'Your application has been received.'
                                    : 'Not started yet.' }}
                            </p>

                        </div>

                    </div>

                    {{-- STEP 2 --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold
                            {{ $latestApplication?->compatibilityAssessment
                                ? 'bg-green-100 text-green-700'
                                : ($latestApplication
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'bg-gray-100 text-gray-400') }}"
                        >
                            @if ($latestApplication?->compatibilityAssessment)
                                &#10003;
                            @else
                                2
                            @endif
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-gray-900">
                                Compatibility Assessment
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                @if ($latestApplication?->compatibilityAssessment)
                                    Your compatibility score is ready.
                                @elseif ($latestApplication)
                                    Waiting for assessment completion.
                                @else
                                    Not started yet.
                                @endif
                            </p>

                        </div>

                    </div>

                    {{-- STEP 3 --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold
                            @if ($latestApplication && in_array($latestApplication->status, ['Approved', 'Rejected']))
                                bg-green-100 text-green-700
                            @elseif ($latestApplication?->compatibilityAssessment)
                                bg-amber-100 text-amber-700
                            @else
                                bg-gray-100 text-gray-400
                            @endif"
                        >
                            @if ($latestApplication && in_array($latestApplication->status, ['Approved', 'Rejected']))
                                &#10003;
                            @else
                                3
                            @endif
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-gray-900">
                                Application Review
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                @if ($latestApplication && in_array($latestApplication->status, ['Approved', 'Rejected']))
                                    Shelter decision recorded.
                                @elseif ($latestApplication?->compatibilityAssessment)
                                    Waiting for shelter approval.
                                @elseif ($latestApplication)
                                    Complete your assessment first.
                                @else
                                    Not started yet.
                                @endif
                            </p>

                        </div>

                    </div>

                    {{-- STEP 4 --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold
                            @if ($latestApplication?->status === 'Approved')
                                bg-green-100 text-green-700
                            @elseif ($latestApplication?->status === 'Rejected')
                                bg-red-100 text-red-700
                            @else
                                bg-gray-100 text-gray-400
                            @endif"
                        >
                            4
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-gray-900">
                                Adoption Decision
                            </p>

                            <p class="mt-1 text-xs
                                @if ($latestApplication?->status === 'Approved')
                                    font-semibold text-green-700
                                @elseif ($latestApplication?->status === 'Rejected')
                                    font-semibold text-red-700
                                @else
                                    text-gray-500
                                @endif"
                            >
                                @if ($latestApplication?->status === 'Approved')
                                    Your application was approved.
                                @elseif ($latestApplication?->status === 'Rejected')
                                    Your application was rejected.
                                @elseif ($latestApplication)
                                    Awaiting final decision.
                                @else
                                    Not started yet.
                                @endif
                            </p>

                        </div>

                    </div>

                </div>

                <div class="mt-4 border-t border-orange-100 pt-3">

                    <p class="text-xs leading-5 text-gray-500">
                        Progress is based on your most recent adoption application.
                    </p>

                </div>

            </div>

        </div>

        {{-- RECOMMENDED PETS --}}
        @if ($recommendedPets->isNotEmpty())

            <div>

                <div class="mb-4">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Made for You
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
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
                            class="group overflow-hidden rounded-2xl border border-orange-100 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg"
                        >

                            <div class="overflow-hidden bg-orange-50">

                                @if ($recommendation->pet->photo)

                                    <img
                                        src="{{ asset('storage/' . $recommendation->pet->photo) }}"
                                        alt="{{ $recommendation->pet->name }}"
                                        class="h-44 w-full object-cover transition duration-300 group-hover:scale-105"
                                    >

                                @else

                                    <div class="flex h-44 items-center justify-center text-sm text-gray-500">
                                        No photo available
                                    </div>

                                @endif

                            </div>

                            <div class="p-5">

                                <div class="flex items-start justify-between gap-3">

                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $recommendation->pet->name }}
                                    </h3>

                                    <span class="rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                        {{ $recommendation->compatibility_score }}%
                                    </span>

                                </div>

                                @php
                                    $petAge = trim($recommendation->pet->age);

                                    $formattedAge = preg_replace_callback(
                                        '/^(\d+)\s+(year|month)s?$/i',
                                        function ($matches) {
                                            return $matches[1] . ' ' .
                                                strtolower($matches[2]) .
                                                ($matches[1] == 1 ? '' : 's') .
                                                ' old';
                                        },
                                        $petAge
                                    );
                                @endphp

                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $recommendation->pet->type }}
                                    • {{ $recommendation->pet->sex }}
                                    • {{ $formattedAge }}
                                </p>

                                <div class="mt-4 flex items-center justify-between border-t border-orange-100 pt-3">

                                    <p class="text-sm font-semibold text-green-700">
                                        {{ $recommendation->classification }}
                                    </p>

                                    <span class="text-sm font-semibold text-orange-500 transition group-hover:translate-x-1">
                                        View →
                                    </span>

                                </div>

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

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Meet Your Companion
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Meet Available Pets
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        These pets are currently looking for a loving home
                    </p>

                </div>

                <a
                    href="{{ route('pets.index') }}"
                    class="text-sm font-semibold text-orange-600 transition hover:text-orange-700"
                >
                    View All Pets →
                </a>

            </div>

            @if ($availablePets->isEmpty())

                <div class="rounded-2xl border border-orange-100 bg-white p-8 text-center text-gray-500 shadow-sm">
                    No pets are currently available for adoption.
                </div>

            @else

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($availablePets as $pet)

                        <a
                            href="{{ route('pets.show', $pet) }}"
                            class="group overflow-hidden rounded-2xl border border-orange-100 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg"
                        >

                            <div class="overflow-hidden bg-orange-50">

                                @if ($pet->photo)

                                    <img
                                        src="{{ asset('storage/' . $pet->photo) }}"
                                        alt="{{ $pet->name }}"
                                        class="h-44 w-full object-cover transition duration-300 group-hover:scale-105"
                                    >

                                @else

                                    <div class="flex h-44 items-center justify-center text-sm text-gray-500">
                                        No photo available
                                    </div>

                                @endif

                            </div>

                            <div class="p-5">

                                <div class="flex items-center justify-between gap-3">

                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $pet->name }}
                                    </h3>

                                    <span class="rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        Available
                                    </span>

                                </div>

                                @php
                                    $petAge = trim($pet->age);

                                    $formattedAge = preg_replace_callback(
                                        '/^(\d+)\s+(year|month)s?$/i',
                                        function ($matches) {
                                            return $matches[1] . ' ' .
                                                strtolower($matches[2]) .
                                                ($matches[1] == 1 ? '' : 's') .
                                                ' old';
                                        },
                                        $petAge
                                    );
                                @endphp

                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $pet->type }}
                                    • {{ $pet->sex }}
                                    • {{ $formattedAge }}
                                </p>

                                <div class="mt-4 flex items-center justify-between border-t border-orange-100 pt-3">

                                    <span class="text-sm font-semibold text-orange-600 transition group-hover:text-orange-700">
                                        View Pet Details
                                    </span>

                                    <span class="text-orange-500 transition group-hover:translate-x-1">
                                        →
                                    </span>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</section>

@endsection