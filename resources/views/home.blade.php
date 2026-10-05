@extends('layouts.app')

@section('title', 'Pawfect Match - Find Your Perfect Companion')


@section('content')


<!-- =========================================
     HERO SECTION
========================================== -->

<section class="overflow-hidden bg-orange-50">

    <div class="mx-auto grid min-h-[600px] max-w-7xl items-center
                gap-12 px-6 py-16
                lg:grid-cols-2 lg:py-24">


        <!-- Hero Text -->
        <div>

            <p class="mb-4 font-semibold uppercase tracking-wider
                      text-orange-500">
                Find. Match. Adopt.
            </p>

            <h1 class="text-4xl font-bold leading-tight text-gray-900
                       sm:text-5xl lg:text-6xl">

                Find Your
                <span class="text-orange-500">
                    Pawfect Match
                </span>

            </h1>


            <p class="mt-6 max-w-xl text-lg leading-8 text-gray-600">

                Find a loving companion that matches your lifestyle,
                home environment, and pet care preferences.

            </p>


            <!-- Hero Buttons -->
            <div class="mt-8 flex flex-wrap gap-4">

                <a href="{{ route('pets.index') }}"
                   class="rounded-full bg-orange-500 px-7 py-3
                          font-semibold text-white
                          shadow-md transition
                          hover:bg-orange-600">

                    Browse Available Pets

                </a>


                <a href="#how-it-works"
                   class="rounded-full border border-orange-500
                          bg-white px-7 py-3
                          font-semibold text-orange-500
                          transition hover:bg-orange-100">

                    How It Works

                </a>

            </div>

        </div>


        <!-- Hero Image -->
        <div class="flex justify-center">

            <img
                src="{{ asset('images/pawfect-hero.png') }}"
                alt="Cat and dog waiting for adoption"
                class="w-full max-w-xl object-contain"
            >

        </div>

    </div>

</section>



<!-- =========================================
     AVAILABLE PETS
========================================== -->

<section id="pets" class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-6">


        <!-- Section Title -->
        <div class="mx-auto mb-12 max-w-2xl text-center">

            <p class="font-semibold text-orange-500">
                Meet Our Pets
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-900
                       sm:text-4xl">

                Looking for a Loving Home

            </h2>

            <p class="mt-4 text-gray-600">

                Get to know some of the pets waiting for their
                forever families.

            </p>

        </div>



        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($featuredPets as $pet)

                <div class="overflow-hidden rounded-2xl bg-orange-50
                            shadow-sm transition hover:-translate-y-1
                            hover:shadow-lg">

                    <div class="h-56 overflow-hidden bg-orange-100">

                        @if ($pet->photo)

                            <img
                                src="{{ asset('storage/' . $pet->photo) }}"
                                alt="{{ $pet->name }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full items-center
                                        justify-center text-gray-400">
                                No photo available
                            </div>

                        @endif

                    </div>


                    <div class="p-6">

                        <div class="flex items-center justify-between gap-3">

                            <h3 class="text-xl font-bold">
                                {{ $pet->name }}
                            </h3>

                            <span class="rounded-full bg-green-100
                                        px-3 py-1 text-xs font-semibold
                                        text-green-700">

                                {{ $pet->status }}

                            </span>

                        </div>


                        <p class="mt-2 text-sm text-gray-500">

                            {{ $pet->type }}
                            •
                            {{ $pet->sex }}
                            •
                            {{ $pet->age }}

                        </p>


                        <p class="mt-4 leading-7 text-gray-600">

                            {{ $pet->description }}

                        </p>


                        <a
                            href="{{ route('pets.show', $pet) }}"
                            class="mt-5 inline-block font-semibold
                                text-orange-500 hover:text-orange-600"
                        >
                            View Profile →
                        </a>

                    </div>

                </div>

            @empty

                <div class="sm:col-span-2 lg:col-span-3
                            rounded-2xl bg-orange-50
                            px-6 py-12 text-center">

                    <p class="text-gray-600">
                        There are currently no pets available for adoption.
                    </p>

                </div>

            @endforelse

        </div>

        <!-- View All Button -->
        <div class="mt-12 text-center">

            <a href="{{ route('pets.index') }}"
               class="inline-block rounded-full border
                      border-orange-500 px-7 py-3
                      font-semibold text-orange-500
                      hover:bg-orange-50">

                View All Available Pets

            </a>

        </div>

    </div>

</section>



<!-- =========================================
     COMPATIBILITY MATCHING
========================================== -->

<section class="bg-orange-100 py-20">

    <div class="mx-auto grid max-w-7xl items-center gap-12
                px-6 lg:grid-cols-2">


        <!-- Illustration -->
        <div class="flex justify-center">

            <div class="flex h-72 w-full max-w-md items-center
                        justify-center rounded-3xl bg-white shadow-sm">

                <div class="text-center">

                    <div class="text-7xl">
                        🐾
                    </div>

                    <div class="mt-4 text-3xl font-bold text-orange-500">
                        92% Match
                    </div>

                    <p class="mt-2 text-gray-500">
                        Example compatibility score
                    </p>

                </div>

            </div>

        </div>


        <!-- Text -->
        <div>

            <p class="font-semibold text-orange-500">
                Compatibility Matching
            </p>


            <h2 class="mt-2 text-3xl font-bold text-gray-900
                       sm:text-4xl">

                More Than Just Finding a Cute Pet

            </h2>


            <p class="mt-5 leading-8 text-gray-600">

                Pawfect Match considers important factors such as
                your available time, household, living environment,
                pet-care experience, and activity level to help
                identify pets that may better fit your lifestyle.

            </p>


            <a href="#how-it-works"
               class="mt-7 inline-block rounded-full bg-orange-500
                      px-7 py-3 font-semibold text-white
                      hover:bg-orange-600">

                Learn How Matching Works

            </a>

        </div>

    </div>

</section>



<!-- =========================================
     HOW IT WORKS
========================================== -->

<section id="how-it-works" class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="mb-14 text-center">

            <p class="font-semibold text-orange-500">
                Adoption Process
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-900
                       sm:text-4xl">

                How Pawfect Match Works

            </h2>

            <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                Follow these steps to find a pet and complete
                the adoption process.
            </p>

        </div>


        <div class="grid gap-8 sm:grid-cols-2
                    lg:grid-cols-5">


            <!-- Step 1 -->
            <div class="text-center">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-orange-100
                            text-2xl font-bold text-orange-500">

                    1

                </div>

                <h3 class="mt-5 text-lg font-bold">
                    Create an Account
                </h3>

                <p class="mt-3 leading-7 text-gray-600">
                    Register and complete your adopter profile.
                </p>

            </div>


            <!-- Step 2 -->
            <div class="text-center">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-orange-100
                            text-2xl font-bold text-orange-500">

                    2

                </div>

                <h3 class="mt-5 text-lg font-bold">
                    Browse Available Pets
                </h3>

                <p class="mt-3 leading-7 text-gray-600">
                    View pets currently available for adoption.
                </p>

            </div>


            <!-- Step 3 -->
            <div class="text-center">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-orange-100
                            text-2xl font-bold text-orange-500">

                    3

                </div>

                <h3 class="mt-5 text-lg font-bold">
                    Apply for Adoption
                </h3>

                <p class="mt-3 leading-7 text-gray-600">
                    Complete and submit the adoption form
                    for your chosen pet.
                </p>

            </div>


            <!-- Step 4 -->
            <div class="text-center">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-orange-100
                            text-2xl font-bold text-orange-500">

                    4

                </div>

                <h3 class="mt-5 text-lg font-bold">
                    Check Compatibility
                </h3>

                <p class="mt-3 leading-7 text-gray-600">
                    Complete the compatibility assessment
                    to see how well the pet matches your
                    lifestyle and home environment.
                </p>

            </div>


            <!-- Step 5 -->
            <div class="text-center">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-orange-100
                            text-2xl font-bold text-orange-500">

                    5

                </div>

                <h3 class="mt-5 text-lg font-bold">
                    Track Your Application
                </h3>

                <p class="mt-3 leading-7 text-gray-600">
                    View your application status and wait
                    for the shelter's decision.
                </p>

            </div>


        </div>

    </div>

</section>



<!-- =========================================
     ABOUT SECTION
========================================== -->

<section id="about" class="bg-orange-50 py-20">

    <div class="mx-auto max-w-4xl px-6 text-center">

        <p class="font-semibold text-orange-500">
            About Pawfect Match
        </p>


        <h2 class="mt-2 text-3xl font-bold text-gray-900
                   sm:text-4xl">

            Helping Pets Find the Right Home

        </h2>


        <p class="mx-auto mt-6 max-w-3xl leading-8 text-gray-600">

            Pawfect Match is a web-based pet adoption and
            compatibility matching system designed for the
            Bayambang Animal Shelter. It aims to support the
            adoption process by helping connect adopters with
            pets based on compatibility.

        </p>


        <a href="#pets"
           class="mt-8 inline-block rounded-full bg-orange-500
                  px-8 py-3 font-semibold text-white
                  hover:bg-orange-600">

            Meet the Pets

        </a>

    </div>

</section>


@endsection