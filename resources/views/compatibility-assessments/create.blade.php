@extends('layouts.app')

@section('title', 'Compatibility Assessment - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-3xl">

        {{-- PAGE HEADER --}}
        <div class="relative overflow-hidden rounded-3xl border border-orange-200 bg-orange-100 px-6 py-8 text-center sm:px-8">

            {{-- Subtle decoration --}}
            <div class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full border-[18px] border-orange-200/60"></div>

            <div class="relative">

                <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                    Step 2
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                    Compatibility Assessment
                </h1>

                <div class="mx-auto mt-4 h-1 w-14 rounded-full bg-orange-400"></div>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                    Review your saved compatibility answers for
                    {{ $application->pet->name }}.
                </p>

            </div>

        </div>

        {{-- SELECTED PET --}}
        <div class="mt-6 rounded-2xl border border-orange-200 bg-white p-5 shadow-sm">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                Your Selected Companion
            </p>

            <p class="mt-2 text-sm text-gray-600">
                You are applying to adopt
            </p>

            <p class="mt-1 text-xl font-bold text-gray-900">
                {{ $application->pet->name }}
            </p>

        </div>

        {{-- IMPORTANT INFORMATION --}}
        <div class="mt-5 rounded-2xl border border-orange-200 bg-orange-50 p-5">

            <p class="text-sm font-semibold text-orange-700">
                Before You Continue
            </p>

            <p class="mt-2 text-sm leading-7 text-gray-600">
                These answers come from your adopter profile.
                They cannot be changed during an adoption application.
                The system will calculate compatibility using the answers shown below.
            </p>

        </div>

        @php
            $profile = auth()->user()->adopterProfile;

            $questions = [
                'care_ability' => 'Ability to Provide Proper Care',
                'available_time' => 'Available Time',
                'household_compatibility' => 'Household',
                'living_environment' => 'Living Environment',
                'pet_care_experience' => 'Pet-care Experience',
                'activity_level' => 'Activity Level',
            ];
        @endphp

        {{-- COMPATIBILITY FORM --}}
        <form
            action="{{ route('compatibility-assessments.store', $application) }}"
            method="POST"
            class="mt-6 rounded-3xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf

            {{-- FORM HEADING --}}
            <div class="mb-6">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Your Saved Answers
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Compatibility Information
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Please review the information below before calculating your compatibility.
                </p>

            </div>

            {{-- ASSESSMENT QUESTIONS --}}
            <div class="grid gap-5 sm:grid-cols-2">

                @foreach ($questions as $field => $label)

                    <div class="rounded-xl border border-orange-100 bg-orange-50/40 p-4">

                        <label class="block text-sm font-semibold text-gray-800">
                            {{ $loop->iteration }}. {{ $label }}
                        </label>

                        <input
                            type="text"
                            value="{{ $profile?->$field ?? 'Not provided' }}"
                            disabled
                            class="mt-3 w-full rounded-xl border border-orange-100 bg-white px-4 py-3 text-sm text-gray-600"
                        >

                    </div>

                @endforeach

            </div>

            {{-- CALCULATE BUTTON --}}
            <div class="mt-8 border-t border-orange-100 pt-6">

                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                >
                    Calculate Compatibility
                </button>

            </div>

        </form>

    </div>

</section>

@endsection