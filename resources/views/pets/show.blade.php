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

                        @if ($existingApplication)

                            <a href="{{ route('adoption-applications.index') }}"
                            class="rounded-full border px-7 py-3 font-semibold

                                @if ($existingApplication->status === 'Approved')
                                    border-green-300 bg-green-50
                                    text-green-700 hover:bg-green-100

                                @elseif ($existingApplication->status === 'Rejected')
                                    border-red-300 bg-red-50
                                    text-red-700 hover:bg-red-100

                                @else
                                    border-yellow-300 bg-yellow-50
                                    text-yellow-700 hover:bg-yellow-100
                                @endif
                            ">

                                Already Applied
                                ({{ $existingApplication->status }})

                            </a>

                            @else

                                <a href="{{ route('adoption-applications.create', $pet) }}"
                                class="rounded-full border border-orange-500
                                        bg-white px-7 py-3 font-semibold
                                        text-orange-500 hover:bg-orange-50">

                                    Apply for Adoption

                                </a>

                            @endif

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

                You will need an adopter account before submitting
                an adoption application.
            
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

@endsection