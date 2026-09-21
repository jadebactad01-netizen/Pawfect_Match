@extends('layouts.app')

@section('title', 'Available Pets - Pawfect Match')


@section('content')


<!-- =========================================
     PAGE HEADER
========================================== -->

<section class="bg-orange-50 py-16">

    <div class="mx-auto max-w-7xl px-6 text-center">

        <p class="font-semibold text-orange-500">
            Find a Companion
        </p>

        <h1 class="mt-2 text-4xl font-bold text-gray-900
                   sm:text-5xl">

            Available Pets

        </h1>

        <p class="mx-auto mt-5 max-w-2xl leading-7 text-gray-600">

            Meet the pets currently looking for their forever homes.
            Browse their profiles and find a companion that may be
            right for you.

        </p>

    </div>

</section>



<!-- =========================================
     SIMPLE FILTER AREA
========================================== -->

<section class="border-b bg-white">

    <div class="mx-auto max-w-7xl px-6 py-6">

        <div class="flex flex-wrap items-center justify-between gap-4">

            <!-- Number of pets -->
            <p class="text-gray-600">

                Showing

                <span class="font-bold text-gray-900">
                    {{ count($pets) }}
                </span>

                available pets

            </p>


            <!--
                These buttons are visual only for now.

                We will make the filters actually work
                in a later step.
            -->
            <div class="flex flex-wrap gap-2">

                <a href="{{ route('pets.index') }}"
                    class="rounded-full bg-orange-500
                           px-5 py-2 text-sm font-semibold
                           text-white">

                    All

                </a>


                <a href="{{ route('pets.index', ['type' => 'Dog']) }}"
                    class="rounded-full border border-gray-300
                           px-5 py-2 text-sm font-semibold
                           text-gray-600
                           hover:border-orange-500
                           hover:text-orange-500">

                    Dogs

                </a>


                <a href="{{ route('pets.index', ['type' => 'Cat']) }}"
                    class="rounded-full border border-gray-300
                           px-5 py-2 text-sm font-semibold
                           text-gray-600
                           hover:border-orange-500
                           hover:text-orange-500">

                    Cats

                </a>

            </div>

        </div>

    </div>

</section>



<!-- =========================================
     PET LIST
========================================== -->

<section class="bg-white py-16">

    <div class="mx-auto max-w-7xl px-6">


        <!--
            Instead of writing six pet cards manually,
            Blade will repeat ONE card for every pet
            inside the $pets variable.
        -->

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">


            @forelse ($pets as $pet)


                <!-- PET CARD -->

                <div class="overflow-hidden rounded-2xl
                            border border-gray-100 bg-white
                            shadow-sm transition
                            hover:-translate-y-1
                            hover:shadow-lg">


                    <!-- Pet Image Placeholder -->

                    <div class="flex h-60 items-center
                                justify-center bg-orange-100
                                text-8xl">

                        {{ $pet->emoji }}

                    </div>



                    <!-- Pet Information -->

                    <div class="p-6">


                        <!-- Name + Status -->

                        <div class="flex items-center
                                    justify-between gap-3">

                            <h2 class="text-2xl font-bold
                                       text-gray-900">

                                {{ $pet->name }}

                            </h2>


                            <span class="rounded-full bg-green-100
                                         px-3 py-1 text-xs
                                         font-semibold text-green-700">

                                {{ $pet->status }}

                            </span>

                        </div>



                        <!-- Basic Information -->

                        <p class="mt-2 text-sm text-gray-500">

                            {{ $pet->type }}
                            •
                            {{ $pet->sex }}
                            •
                            {{ $pet->age }}

                        </p>



                        <!-- Description -->

                        <p class="mt-4 leading-7 text-gray-600">

                            {{ $pet->description }}

                        </p>



                        <!-- Button -->

                        <a href="{{ route('pets.show', $pet) }}"
                           class="mt-6 inline-block
                                  rounded-full bg-orange-500
                                  px-6 py-2.5 font-semibold
                                  text-white
                                  hover:bg-orange-600">

                            View Profile

                        </a>


                    </div>

                </div>


            @empty

                <div class="sm:col-span-2 lg:col-span-3
                            rounded-2xl bg-orange-50
                            px-6 py-16 text-center">

                    <div class="text-5xl">
                        🐾
                    </div>

                    <h2 class="mt-4 text-2xl font-bold text-gray-900">
                        No Pets Found
                    </h2>

                    <p class="mt-3 text-gray-600">
                        There are currently no available pets
                        matching this filter.
                    </p>

                    <a href="{{ route('pets.index') }}"
                    class="mt-6 inline-block rounded-full
                            bg-orange-500 px-6 py-3
                            font-semibold text-white
                            hover:bg-orange-600">

                        View All Pets

                    </a>

                </div>

            @endforelse


        </div>


    </div>

</section>



<!-- =========================================
     ADOPTION MESSAGE
========================================== -->

<section class="bg-orange-50 py-16">

    <div class="mx-auto max-w-3xl px-6 text-center">

        <div class="text-5xl">
            🐾
        </div>

        <h2 class="mt-5 text-3xl font-bold text-gray-900">

            Can't Decide Yet?

        </h2>

        <p class="mt-4 leading-7 text-gray-600">

            Pawfect Match will help you compare your lifestyle
            and preferences with the needs and characteristics
            of available pets.

        </p>

        <a href="{{ route('home') }}#how-it-works"
           class="mt-7 inline-block rounded-full
                  border border-orange-500
                  px-7 py-3 font-semibold
                  text-orange-500
                  hover:bg-orange-100">

            Learn About Compatibility Matching

        </a>

    </div>

</section>


@endsection