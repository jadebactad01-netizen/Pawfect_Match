@extends('layouts.app')

@section('title', 'Pawfect Match - Find Your Perfect Companion')

@section('content')

{{-- HERO SECTION --}}
<section class="bg-orange-50/40 py-12 sm:py-16 lg:py-20">

    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-14">

        {{-- HERO TEXT --}}
        <div>

            <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                Find. Match. Adopt.
            </p>

            <h1 class="mt-4 text-4xl font-bold leading-tight text-gray-900 sm:text-5xl lg:text-6xl">
                Find Your
                <span class="text-orange-500">
                    Pawfect Match
                </span>
            </h1>

            <p class="mt-5 max-w-xl text-base leading-8 text-gray-600 sm:text-lg">
                Find a loving companion that matches your lifestyle,
                home environment, and pet care preferences.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">

                <a
                    href="{{ route('pets.index') }}"
                    class="inline-flex items-center justify-center rounded-full bg-orange-500 px-7 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Browse Available Pets
                </a>

                <a
                    href="#how-it-works"
                    class="inline-flex items-center justify-center rounded-full border border-orange-200 bg-white px-7 py-3 text-sm font-semibold text-orange-600 transition hover:bg-orange-50"
                >
                    How It Works
                </a>

            </div>

        </div>

        {{-- HERO IMAGE --}}
        <div class="flex justify-center">

            <img
                src="{{ asset('images/pawfect-hero.png') }}"
                alt="Cat and dog waiting for adoption"
                class="w-full max-w-xl object-contain"
            >

        </div>

    </div>

</section>

{{-- AVAILABLE PETS --}}
<section id="pets" class="border-t border-orange-100 bg-white py-14 sm:py-20">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        {{-- SECTION HEADER --}}
        <div class="mx-auto mb-10 max-w-2xl text-center">

            <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                Meet Our Pets
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                Looking for a Loving Home
            </h2>

            <p class="mt-4 text-sm leading-7 text-gray-600 sm:text-base">
                Get to know some of the pets waiting for their
                forever families.
            </p>

        </div>

        {{-- FEATURED PETS --}}
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($featuredPets as $pet)

                <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-orange-100 bg-white shadow-sm transition hover:border-orange-200 hover:shadow-md">

                    {{-- PET PHOTO --}}
                    <div class="h-56 overflow-hidden bg-orange-50">

                        @if ($pet->photo)

                            <img
                                src="{{ asset('storage/' . $pet->photo) }}"
                                alt="{{ $pet->name }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full items-center justify-center text-sm text-gray-400">
                                No photo available
                            </div>

                        @endif

                    </div>

                    {{-- PET DETAILS --}}
                    <div class="flex flex-1 flex-col p-5 sm:p-6">

                        <div class="flex flex-wrap items-center justify-between gap-3">

                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $pet->name }}
                            </h3>

                            <span class="rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                {{ $pet->status }}
                            </span>

                        </div>

                        <p class="mt-3 text-sm text-gray-500">
                            {{ $pet->type }}
                            •
                            {{ $pet->sex }}
                            •
                            {{ $pet->age }}
                        </p>

                        <p class="mt-4 flex-1 text-sm leading-7 text-gray-600">
                            {{ $pet->description }}
                        </p>

                        <a
                            href="{{ route('pets.show', $pet) }}"
                            class="mt-5 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
                        >
                            View Profile →
                        </a>

                    </div>

                </div>

            @empty

                <div class="rounded-2xl border border-orange-100 bg-orange-50/40 px-6 py-12 text-center sm:col-span-2 lg:col-span-3">

                    <p class="text-sm text-gray-600">
                        There are currently no pets available for adoption.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- VIEW ALL PETS --}}
        <div class="mt-10 text-center">

            <a
                href="{{ route('pets.index') }}"
                class="inline-flex items-center justify-center rounded-full border border-orange-200 bg-white px-7 py-3 text-sm font-semibold text-orange-600 transition hover:bg-orange-50"
            >
                View All Available Pets
            </a>

        </div>

    </div>

</section>

{{-- COMPATIBILITY MATCHING --}}
<section class="border-y border-orange-100 bg-orange-50/40 py-14 sm:py-20">

    <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:gap-12">

        {{-- EXAMPLE COMPATIBILITY SCORE --}}
        <div class="flex justify-center">

            <div class="flex min-h-64 w-full max-w-md items-center justify-center rounded-2xl border border-orange-100 bg-white p-8 text-center shadow-sm">

                <div>

                    <p class="text-4xl font-bold text-orange-500 sm:text-5xl">
                        92% Match
                    </p>

                    <p class="mt-3 text-sm text-gray-500">
                        Example compatibility score
                    </p>

                </div>

            </div>

        </div>

        {{-- COMPATIBILITY EXPLANATION --}}
        <div>

            <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                Compatibility Matching
            </p>

            <h2 class="mt-3 text-3xl font-bold leading-tight text-gray-900 sm:text-4xl">
                More Than Just Finding a Cute Pet
            </h2>

            <p class="mt-5 text-base leading-8 text-gray-600">
                Pawfect Match considers important factors such as
                your available time, household, living environment,
                pet-care experience, and activity level to help
                identify pets that may better fit your lifestyle.
            </p>

            <a
                href="#how-it-works"
                class="mt-7 inline-flex items-center justify-center rounded-full bg-orange-500 px-7 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
            >
                Learn How Matching Works
            </a>

        </div>

    </div>

</section>

{{-- HOW IT WORKS --}}
<section id="how-it-works" class="bg-white py-16 sm:py-20 lg:py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        {{-- SECTION HEADER --}}
        <div class="mx-auto mb-14 max-w-3xl text-center">

            <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                Adoption Process
            </p>

            <h2 class="mt-3 text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
                How Pawfect Match Works
            </h2>

            <p class="mt-5 text-sm leading-7 text-gray-600 sm:text-base">
                Follow these steps to find a pet and complete the adoption process.
            </p>

        </div>

        {{-- STEPS --}}
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-5">

            {{-- STEP 1 --}}
            <div class="text-center">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-orange-100 text-2xl font-bold text-orange-600 transition hover:scale-105">
                    1
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Create an Account
                </h3>

                <p class="mt-4 text-base leading-9 text-gray-600">
                    Register and complete your
                    adopter profile.
                </p>

            </div>

            {{-- STEP 2 --}}
            <div class="text-center">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-orange-100 text-2xl font-bold text-orange-600 transition hover:scale-105">
                    2
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Browse Available Pets
                </h3>

                <p class="mt-4 text-base leading-9 text-gray-600">
                    View pets currently available
                    for adoption.
                </p>

            </div>

            {{-- STEP 3 --}}
            <div class="text-center">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-orange-100 text-2xl font-bold text-orange-600 transition hover:scale-105">
                    3
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Apply for Adoption
                </h3>

                <p class="mt-4 text-base leading-9 text-gray-600">
                    Complete and submit the
                    adoption form for your chosen
                    pet.
                </p>

            </div>

            {{-- STEP 4 --}}
            <div class="text-center">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-orange-100 text-2xl font-bold text-orange-600 transition hover:scale-105">
                    4
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Check Compatibility
                </h3>

                <p class="mt-4 text-base leading-9 text-gray-600">
                    Complete the compatibility
                    assessment to see how well
                    the pet matches your lifestyle
                    and home environment.
                </p>

            </div>

            {{-- STEP 5 --}}
            <div class="text-center">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-orange-100 text-2xl font-bold text-orange-600 transition hover:scale-105">
                    5
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Track Your Application
                </h3>

                <p class="mt-4 text-base leading-9 text-gray-600">
                    View your application status
                    and wait for the shelter's
                    decision.
                </p>

            </div>

        </div>

    </div>

</section>

{{-- ABOUT SECTION --}}
<section id="about" class="border-t border-orange-100 bg-orange-50/40 py-14 sm:py-20">

    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6">

        <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
            About Pawfect Match
        </p>

        <h2 class="mt-3 text-3xl font-bold text-gray-900 sm:text-4xl">
            Helping Pets Find the Right Home
        </h2>

        <p class="mx-auto mt-6 max-w-3xl text-base leading-8 text-gray-600">
            Pawfect Match is a web-based pet adoption and
            compatibility matching system designed for the
            Bayambang Animal Shelter. It aims to support the
            adoption process by helping connect adopters with
            pets based on compatibility.
        </p>

        <a
            href="#pets"
            class="mt-8 inline-flex items-center justify-center rounded-full bg-orange-500 px-8 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
        >
            Meet the Pets
        </a>

    </div>

</section>

@endsection