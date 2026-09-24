@extends('layouts.app')

@section('title', $pet->name . ' - Pawfect Match')


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

@if (session('success') || session('error'))

    <div class="bg-orange-50 px-6 pt-6">

        <div class="mx-auto max-w-7xl">

            @if (session('success'))
                <div class="rounded-xl border border-green-200
                            bg-green-50 px-5 py-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-xl border border-red-200
                            bg-red-50 px-5 py-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

        </div>

    </div>

@endif

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

                {{ $pet->emoji }}

            </div>

        </div>



        <!-- PET INFORMATION -->
        <div>


            <!-- Status -->
            <span class="inline-block rounded-full
                        px-4 py-2 text-sm font-semibold
                        {{ $pet->status === 'Available'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">

                {{ $pet->status }}

            </span>



            <!-- Name -->
            <h1 class="mt-4 text-4xl font-bold text-gray-900
                       sm:text-5xl">

                {{ $pet->name }}

            </h1>



            <!-- Short Description -->
            <p class="mt-5 text-lg leading-8 text-gray-600">

                {{ $pet->description }}

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
                        {{ $pet->type }}
                    </p>

                </div>



                <!-- Sex -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Sex
                    </p>

                    <p class="mt-1 font-bold text-gray-900">
                        {{ $pet->sex }}
                    </p>

                </div>



                <!-- Age -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Age
                    </p>

                    <p class="mt-1 font-bold text-gray-900">
                        {{ $pet->age }}
                    </p>

                </div>



                <!-- Adoption Status -->
                <div class="rounded-2xl bg-white p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Adoption Status
                    </p>

                <p class="mt-1 font-bold
                        {{ $pet->status === 'Available'
                            ? 'text-green-600'
                            : 'text-red-600' }}">

                    {{ $pet->status }}

                </p>

                </div>


            </div>



            <!-- =========================================
                 BUTTONS
            ========================================== -->

            <div class="mt-8 flex flex-wrap gap-4">

            @guest

                <a href="{{ route('login') }}"
                class="rounded-full bg-orange-500 px-7 py-3
                        font-semibold text-white
                        hover:bg-orange-600">

                    Log In to Check Compatibility

                </a>

            @else

                @if (auth()->user()->role === 'adopter')

                    @if ($profile)

                        <a href="#compatibility-result"
                        class="rounded-full bg-orange-500 px-7 py-3
                                font-semibold text-white
                                hover:bg-orange-600">

                            View Compatibility

                        </a>

                    @else

                        <a href="{{ route('profile.edit') }}"
                        class="rounded-full bg-orange-500 px-7 py-3
                                font-semibold text-white
                                hover:bg-orange-600">

                            Complete My Profile

                        </a>

                    @endif

                @endif

            @endguest

            @if ($pet->status === 'Available')

                @guest

                    <a href="{{ route('login') }}"
                    class="rounded-full border border-orange-500
                            bg-white px-7 py-3 font-semibold
                            text-orange-500 hover:bg-orange-50">
                        Log In to Apply
                    </a>

                @else

                    @if (auth()->user()->role === 'adopter')

                        @if ($profile)

                            <a href="{{ route('adoption-applications.create', $pet) }}"
                            class="rounded-full border border-orange-500
                                    bg-white px-7 py-3 font-semibold
                                    text-orange-500 hover:bg-orange-50">
                                Apply for Adoption
                            </a>

                        @else

                            <a href="{{ route('profile.edit') }}"
                            class="rounded-full border border-orange-500
                                    bg-white px-7 py-3 font-semibold
                                    text-orange-500 hover:bg-orange-50">
                                Complete Profile to Apply
                            </a>

                        @endif

                    @endif

                @endguest

            @endif


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
                About {{ $pet->name }}
            </h2>

            <p class="mt-5 leading-8 text-gray-600">

                {{ $pet->description }}

            </p>

        </div>


    </div>

</section>



<!-- =========================================
     COMPATIBILITY
========================================== -->

<section id="compatibility-result"
         class="bg-orange-100 py-16">

    <div class="mx-auto max-w-4xl px-6">


        @if ($compatibility)

            <!-- RESULT -->

            <div class="text-center">

                <p class="font-semibold text-orange-500">
                    Your Compatibility
                </p>

                <h2 class="mt-2 text-5xl font-bold text-gray-900">
                    {{ $compatibility['score'] }}%
                </h2>

                <p class="mt-3 text-xl font-bold text-gray-800">
                    {{ $compatibility['classification'] }}
                </p>

                <p class="mx-auto mt-4 max-w-2xl
                          leading-7 text-gray-600">

                    This score compares your adopter profile with
                    {{ $pet->name }}'s compatibility requirements.

                </p>

            </div>


            <!-- FACTOR BREAKDOWN -->

            <div class="mt-10 rounded-3xl bg-white
                        p-6 shadow-sm sm:p-8">

                <h3 class="text-xl font-bold text-gray-900">
                    Compatibility Breakdown
                </h3>


                <div class="mt-6 space-y-4">

                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-4">

                        <span class="text-gray-600">
                            Care Ability
                        </span>

                        <span class="font-bold text-gray-900">
                            {{ $compatibility['factors']['care_ability']['score'] }}
                            /
                            {{ $compatibility['factors']['care_ability']['possible'] }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-4">

                        <span class="text-gray-600">
                            Available Time
                        </span>

                        <span class="font-bold text-gray-900">
                            {{ $compatibility['factors']['available_time']['score'] }}
                            /
                            {{ $compatibility['factors']['available_time']['possible'] }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-4">

                        <span class="text-gray-600">
                            Household Compatibility
                        </span>

                        <span class="font-bold text-gray-900">
                            {{ $compatibility['factors']['household_compatibility']['score'] }}
                            /
                            {{ $compatibility['factors']['household_compatibility']['possible'] }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-4">

                        <span class="text-gray-600">
                            Living Environment
                        </span>

                        <span class="font-bold text-gray-900">
                            {{ $compatibility['factors']['living_environment']['score'] }}
                            /
                            {{ $compatibility['factors']['living_environment']['possible'] }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-4">

                        <span class="text-gray-600">
                            Pet Care Experience
                        </span>

                        <span class="font-bold text-gray-900">
                            {{ $compatibility['factors']['pet_care_experience']['score'] }}
                            /
                            {{ $compatibility['factors']['pet_care_experience']['possible'] }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between">

                        <span class="text-gray-600">
                            Activity Level
                        </span>

                        <span class="font-bold text-gray-900">
                            {{ $compatibility['factors']['activity_level']['score'] }}
                            /
                            {{ $compatibility['factors']['activity_level']['possible'] }}
                        </span>

                    </div>

                </div>

            </div>


        @guest

            <!-- GUEST -->

            <div class="text-center">

                <div class="text-5xl">
                    🐾
                </div>

                <h2 class="mt-5 text-3xl font-bold text-gray-900">
                    Could {{ $pet->name }} Be Your Pawfect Match?
                </h2>

                <p class="mx-auto mt-4 max-w-2xl
                          leading-7 text-gray-600">

                    Log in and complete your adopter profile to
                    calculate your compatibility with this pet.

                </p>

                <a href="{{ route('login') }}"
                   class="mt-7 inline-block rounded-full
                          bg-orange-500 px-8 py-3
                          font-semibold text-white
                          hover:bg-orange-600">

                    Log In

                </a>

            </div>


        @else

            @if (auth()->user()->role === 'adopter' && ! $profile)

                <!-- ADOPTER WITHOUT PROFILE -->

                <div class="text-center">

                    <div class="text-5xl">
                        🐾
                    </div>

                    <h2 class="mt-5 text-3xl font-bold text-gray-900">
                        Complete Your Adopter Profile
                    </h2>

                    <p class="mx-auto mt-4 max-w-2xl
                              leading-7 text-gray-600">

                        We need your lifestyle and household
                        information before calculating your
                        compatibility with {{ $pet->name }}.

                    </p>

                    <a href="{{ route('profile.edit') }}"
                       class="mt-7 inline-block rounded-full
                              bg-orange-500 px-8 py-3
                              font-semibold text-white
                              hover:bg-orange-600">

                        Complete My Profile

                    </a>

                </div>

            @endif

        @endguest


        @endif

    </div>

</section>


@endsection