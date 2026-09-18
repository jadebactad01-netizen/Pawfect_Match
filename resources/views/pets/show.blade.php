@extends('layouts.app')

@section('title', $pet['name'] . ' - Pawfect Match')


@section('content')


<!-- =========================================
     BACK BUTTON
========================================== -->

<section class="bg-orange-50">

    <div class="mx-auto max-w-7xl px-6 pt-10">

        <a href="{{ route('pets.index') }}"
           class="font-semibold text-orange-500 hover:text-orange-600">

            ← Back to Available Pets

        </a>

    </div>

</section>



<!-- =========================================
     PET PROFILE
========================================== -->

<section class="bg-orange-50 py-12">

    <div class="mx-auto grid max-w-7xl gap-12 px-6
                lg:grid-cols-2">


        <!-- PET IMAGE -->
        <div>

            <div class="flex min-h-[400px] items-center
                        justify-center rounded-3xl
                        bg-orange-100 text-9xl">

                {{ $pet['emoji'] }}

            </div>

        </div>



        <!-- PET INFORMATION -->
        <div>


            <!-- Status -->
            <span class="inline-block rounded-full bg-green-100
                         px-4 py-2 text-sm font-semibold
                         text-green-700">

                {{ $pet['status'] }}

            </span>



            <!-- Name -->
            <h1 class="mt-4 text-4xl font-bold text-gray-900
                       sm:text-5xl">

                {{ $pet['name'] }}

            </h1>



            <!-- Short Description -->
            <p class="mt-5 text-lg leading-8 text-gray-600">

                {{ $pet['description'] }}

            </p>



            <!-- =========================================
                 BASIC INFORMATION
            ========================================== -->

            <div class="mt-8 grid grid-cols-2 gap-4">


                <!-- Type -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Type
                    </p>

                    <p class="mt-1 font-bold text-gray-900">
                        {{ $pet['type'] }}
                    </p>

                </div>



                <!-- Sex -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Sex
                    </p>

                    <p class="mt-1 font-bold text-gray-900">
                        {{ $pet['sex'] }}
                    </p>

                </div>



                <!-- Age -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Age
                    </p>

                    <p class="mt-1 font-bold text-gray-900">
                        {{ $pet['age'] }}
                    </p>

                </div>



                <!-- Adoption Status -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Adoption Status
                    </p>

                    <p class="mt-1 font-bold text-green-600">
                        {{ $pet['status'] }}
                    </p>

                </div>


            </div>



            <!-- =========================================
                 BUTTONS
            ========================================== -->

            <div class="mt-8 flex flex-wrap gap-4">


                <!-- Not functional yet -->
                <a href="#"
                   class="rounded-full bg-orange-500 px-7 py-3
                          font-semibold text-white
                          hover:bg-orange-600">

                    Check Compatibility

                </a>


                <!-- Not functional yet -->
                <a href="#"
                   class="rounded-full border border-orange-500
                          bg-white px-7 py-3
                          font-semibold text-orange-500
                          hover:bg-orange-50">

                    Apply for Adoption

                </a>


            </div>


            <!-- Explanation -->
            <p class="mt-4 text-sm text-gray-500">

                You will need an adopter account before completing
                the compatibility assessment or submitting an
                adoption application.

            </p>


        </div>

    </div>

</section>



<!-- =========================================
     ABOUT THIS PET
========================================== -->

<section class="bg-white py-16">

    <div class="mx-auto max-w-7xl px-6">


        <div class="max-w-3xl">

            <p class="font-semibold text-orange-500">
                Pet Profile
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-900">
                About {{ $pet['name'] }}
            </h2>

            <p class="mt-5 leading-8 text-gray-600">

                {{ $pet['description'] }}

            </p>

        </div>


    </div>

</section>



<!-- =========================================
     COMPATIBILITY MESSAGE
========================================== -->

<section class="bg-orange-100 py-16">

    <div class="mx-auto max-w-4xl px-6 text-center">

        <div class="text-5xl">
            🐾
        </div>

        <h2 class="mt-5 text-3xl font-bold text-gray-900">

            Could {{ $pet['name'] }} Be Your Pawfect Match?

        </h2>

        <p class="mx-auto mt-4 max-w-2xl leading-7
                  text-gray-600">

            Complete the compatibility assessment to help determine
            how well your lifestyle, home environment, and pet-care
            preferences match this pet.

        </p>


        <!-- Not functional yet -->
        <a href="#"
           class="mt-7 inline-block rounded-full
                  bg-orange-500 px-8 py-3
                  font-semibold text-white
                  hover:bg-orange-600">

            Check Compatibility

        </a>

    </div>

</section>


@endsection