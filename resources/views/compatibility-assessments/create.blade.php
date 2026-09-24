@extends('layouts.app')

@section('title', 'Compatibility Assessment - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-3xl">

        {{-- Heading --}}
        <div class="text-center">

            <p class="font-semibold text-orange-500">
                Step 2
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                Compatibility Assessment
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                Answer these questions to help determine your
                compatibility with {{ $application->pet->name }}.
            </p>

        </div>


        {{-- Pet --}}
        <div class="mt-8 rounded-2xl bg-orange-100 p-5">

            <p class="text-sm text-gray-600">
                You are applying to adopt
            </p>

            <p class="mt-1 text-xl font-bold text-gray-900">
                {{ $application->pet->name }}
            </p>

        </div>


        {{-- Errors --}}
        @if ($errors->any())

            <div class="mt-6 rounded-xl border border-red-200
                        bg-red-50 p-4 text-red-700">

                <p class="font-semibold">
                    Please answer all questions.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <form
            action="{{ route(
                'compatibility-assessments.store',
                $application
            ) }}"
            method="POST"
            class="mt-8 space-y-8 rounded-3xl
                   bg-white p-6 shadow-sm sm:p-8"
        >

            @csrf


            {{-- =====================================
                 1. CARE ABILITY
            ====================================== --}}

            <div>

                <label for="care_ability"
                       class="text-lg font-bold text-gray-900">
                    1. Ability to Provide Proper Care
                </label>

                <p class="mt-1 text-sm text-gray-500">
                    How would you describe your ability to provide
                    food, veterinary care, grooming, and other needs?
                </p>

                <select
                    id="care_ability"
                    name="care_ability"
                    required
                    class="mt-3 w-full rounded-xl border
                           border-gray-300 bg-white px-4 py-3"
                >
                    <option value="">Select an answer</option>

                    <option value="Limited"
                        @selected(old('care_ability') === 'Limited')>
                        Limited
                    </option>

                    <option value="Moderate"
                        @selected(old('care_ability') === 'Moderate')>
                        Moderate
                    </option>

                    <option value="High"
                        @selected(old('care_ability') === 'High')>
                        High
                    </option>
                </select>

            </div>


            {{-- =====================================
                 2. AVAILABLE TIME
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <label for="available_time"
                       class="text-lg font-bold text-gray-900">
                    2. Available Time
                </label>

                <p class="mt-1 text-sm text-gray-500">
                    How much time can you regularly give to a pet?
                </p>

                <select
                    id="available_time"
                    name="available_time"
                    required
                    class="mt-3 w-full rounded-xl border
                           border-gray-300 bg-white px-4 py-3"
                >
                    <option value="">Select an answer</option>

                    @foreach (['Low', 'Moderate', 'High'] as $option)

                        <option value="{{ $option }}"
                            @selected(old('available_time') === $option)>
                            {{ $option }}
                        </option>

                    @endforeach
                </select>

            </div>


            {{-- =====================================
                 3. HOUSEHOLD
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <label for="household_compatibility"
                       class="text-lg font-bold text-gray-900">
                    3. Household
                </label>

                <p class="mt-1 text-sm text-gray-500">
                    Which best describes your household?
                </p>

                <select
                    id="household_compatibility"
                    name="household_compatibility"
                    required
                    class="mt-3 w-full rounded-xl border
                           border-gray-300 bg-white px-4 py-3"
                >
                    <option value="">Select an answer</option>

                    @foreach ([
                        'Living alone',
                        'Adults only',
                        'Family with children'
                    ] as $option)

                        <option value="{{ $option }}"
                            @selected(
                                old('household_compatibility') === $option
                            )>
                            {{ $option }}
                        </option>

                    @endforeach
                </select>

            </div>


            {{-- =====================================
                 4. LIVING ENVIRONMENT
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <label for="living_environment"
                       class="text-lg font-bold text-gray-900">
                    4. Living Environment
                </label>

                <p class="mt-1 text-sm text-gray-500">
                    What type of home do you currently live in?
                </p>

                <select
                    id="living_environment"
                    name="living_environment"
                    required
                    class="mt-3 w-full rounded-xl border
                           border-gray-300 bg-white px-4 py-3"
                >
                    <option value="">Select an answer</option>

                    @foreach (['House', 'Apartment', 'Other'] as $option)

                        <option value="{{ $option }}"
                            @selected(
                                old('living_environment') === $option
                            )>
                            {{ $option }}
                        </option>

                    @endforeach
                </select>

            </div>


            {{-- =====================================
                 5. PET-CARE EXPERIENCE
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <label for="pet_care_experience"
                       class="text-lg font-bold text-gray-900">
                    5. Pet-care Experience
                </label>

                <p class="mt-1 text-sm text-gray-500">
                    How much experience do you have caring for pets?
                </p>

                <select
                    id="pet_care_experience"
                    name="pet_care_experience"
                    required
                    class="mt-3 w-full rounded-xl border
                           border-gray-300 bg-white px-4 py-3"
                >
                    <option value="">Select an answer</option>

                    @foreach (['None', 'Some', 'Experienced'] as $option)

                        <option value="{{ $option }}"
                            @selected(
                                old('pet_care_experience') === $option
                            )>
                            {{ $option }}
                        </option>

                    @endforeach
                </select>

            </div>


            {{-- =====================================
                 6. ACTIVITY LEVEL
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <label for="activity_level"
                       class="text-lg font-bold text-gray-900">
                    6. Activity Level
                </label>

                <p class="mt-1 text-sm text-gray-500">
                    How would you describe your normal activity level?
                </p>

                <select
                    id="activity_level"
                    name="activity_level"
                    required
                    class="mt-3 w-full rounded-xl border
                           border-gray-300 bg-white px-4 py-3"
                >
                    <option value="">Select an answer</option>

                    @foreach (['Low', 'Moderate', 'High'] as $option)

                        <option value="{{ $option }}"
                            @selected(old('activity_level') === $option)>
                            {{ $option }}
                        </option>

                    @endforeach
                </select>

            </div>


            {{-- Submit --}}
            <div class="border-t border-gray-200 pt-8">

                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500
                           px-8 py-3 font-semibold text-white
                           hover:bg-orange-600"
                >
                    Calculate Compatibility
                </button>

            </div>

        </form>

    </div>

</section>

@endsection