@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl px-6">

        {{-- Welcome --}}
        <div class="rounded-3xl bg-orange-500 p-8 text-white">

            <p class="font-semibold text-orange-100">
                Welcome
            </p>

            <h1 class="mt-1 text-3xl font-bold">
                {{ auth()->user()->name }}
            </h1>

            <p class="mt-3 max-w-2xl text-orange-50">
                Keep track of your adoption journey and
                discover pets that may be a good match for you.
            </p>

        </div>


        {{-- Adoption overview --}}
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    My Applications
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $applications->count() }}
                </p>

                <a
                    href="{{ route('adoption-applications.index') }}"
                    class="mt-4 inline-block text-sm font-semibold
                           text-orange-500 hover:text-orange-600"
                >
                    View Applications →
                </a>

            </div>


            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    Pending
                </p>

                <p class="mt-2 text-3xl font-bold text-yellow-600">
                    {{ $pendingApplications }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Applications waiting for a decision.
                </p>

            </div>


            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-sm font-semibold text-gray-500">
                    Approved
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ $approvedApplications }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Approved adoption applications.
                </p>

            </div>

        </div>


        {{-- Current adoption journey --}}
        <div class="mt-10">

            <h2 class="text-xl font-bold text-gray-900">
                My Adoption Journey
            </h2>

            @if ($latestApplication)

                <div class="mt-4 rounded-2xl bg-white p-6 shadow-sm">

                    <div class="flex flex-col gap-6
                                sm:flex-row sm:items-center">

                        @if ($latestApplication->pet->photo)

                            <img
                                src="{{ asset(
                                    'storage/' . $latestApplication->pet->photo
                                ) }}"
                                alt="{{ $latestApplication->pet->name }}"
                                class="h-24 w-24 shrink-0 rounded-2xl object-cover"
                            >

                        @else

                            <div class="flex h-24 w-24 shrink-0 items-center
                                        justify-center rounded-2xl bg-orange-50
                                        text-center text-xs text-gray-400">
                                No photo
                            </div>

                        @endif

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-gray-500">
                                Latest Application
                            </p>

                            <h3 class="mt-1 text-xl font-bold text-gray-900">
                                {{ $latestApplication->pet->name }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $latestApplication->pet->type }}
                                •
                                {{ $latestApplication->pet->sex }}
                                •
                                {{ $latestApplication->pet->age }}
                            </p>

                            <div class="mt-3">

                                <span class="rounded-full bg-orange-100
                                             px-3 py-1 text-sm font-semibold
                                             text-orange-700">

                                    {{ $latestApplication->status }}

                                </span>

                            </div>


                            @if (
                                $latestApplication
                                    ->compatibilityAssessment
                            )

                                <p class="mt-4 text-sm text-gray-600">
                                    Compatibility:
                                    <span class="font-bold text-gray-900">
                                        {{
                                            $latestApplication
                                                ->compatibilityAssessment
                                                ->total_score
                                        }}%
                                    </span>

                                    —
                                    {{
                                        $latestApplication
                                            ->compatibilityAssessment
                                            ->classification
                                    }}
                                </p>

                            @else

                                <a
                                    href="{{
                                        route(
                                            'compatibility-assessments.create',
                                            $latestApplication
                                        )
                                    }}"
                                    class="mt-4 inline-block font-semibold
                                           text-orange-500
                                           hover:text-orange-600"
                                >
                                    Complete Compatibility Assessment →
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            @else

                <div class="mt-4 rounded-2xl bg-white p-8 shadow-sm">

                    <h3 class="font-bold text-gray-900">
                        Start your adoption journey
                    </h3>

                    <p class="mt-2 text-gray-600">
                        You haven't submitted an adoption
                        application yet.
                    </p>

                    <a
                        href="{{ route('pets.index') }}"
                        class="mt-4 inline-block rounded-full
                               bg-orange-500 px-5 py-2
                               font-semibold text-white
                               hover:bg-orange-600"
                    >
                        Browse Available Pets
                    </a>

                </div>

            @endif

        </div>

        {{-- Recommendations --}}
        @if ($recommendedPets->isNotEmpty())

            <div class="mt-10">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Recommended for You
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Based on your latest compatibility assessment.
                    </p>
                </div>

                <div class="mt-4 grid gap-6
                            sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($recommendedPets as $recommendation)

                        <a
                            href="{{ route('pets.show', $recommendation->pet) }}"
                            class="mx-auto w-full max-w-sm overflow-hidden
                                rounded-2xl bg-white shadow-sm transition
                                hover:-translate-y-1 hover:shadow-md"
                        >

                            @if ($recommendation->pet->photo)

                                <img
                                    src="{{ asset(
                                        'storage/' . $recommendation->pet->photo
                                    ) }}"
                                    alt="{{ $recommendation->pet->name }}"
                                    class="h-40 w-full object-cover"
                                >

                            @else

                                <div class="flex h-40 w-full items-center
                                            justify-center bg-orange-50
                                            text-gray-400">
                                    No photo available
                                </div>

                            @endif

                            <div class="p-5">

                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $recommendation->pet->name }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $recommendation->pet->type }}
                                    •
                                    {{ $recommendation->pet->sex }}
                                    •
                                    {{ $recommendation->pet->age }}
                                </p>

                                <p class="mt-3 font-semibold text-orange-500">
                                    {{ $recommendation->compatibility_score }}%
                                    Match
                                </p>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $recommendation->classification }}
                                </p>

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        @endif

        {{-- Available Pets --}}
        <div class="mt-10">

            <div class="flex items-end justify-between gap-4">

                <div>

                    <h2 class="text-xl font-bold text-gray-900">
                        Available Pets
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Meet some of the pets currently
                        looking for a home.
                    </p>

                </div>

                <a
                    href="{{ route('pets.index') }}"
                    class="text-sm font-semibold text-orange-500
                        hover:text-orange-600"
                >
                    View All
                </a>

            </div>

            <div class="mt-4 grid gap-6
                        sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($availablePets as $pet)

                    <a
                        href="{{ route('pets.show', $pet) }}"
                        class="mx-auto w-full max-w-sm overflow-hidden
                            rounded-2xl bg-white shadow-sm transition
                            hover:-translate-y-1 hover:shadow-md"
                    >

                        @if ($pet->photo)

                            <img
                                src="{{ asset('storage/' . $pet->photo) }}"
                                alt="{{ $pet->name }}"
                                class="h-40 w-full object-cover"
                            >

                        @else

                            <div class="flex h-40 w-full items-center
                                        justify-center bg-orange-50
                                        text-gray-400">
                                No photo available
                            </div>

                        @endif

                        <div class="p-5">

                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $pet->name }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $pet->type }}
                                •
                                {{ $pet->sex }}
                                •
                                {{ $pet->age }}
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endsection