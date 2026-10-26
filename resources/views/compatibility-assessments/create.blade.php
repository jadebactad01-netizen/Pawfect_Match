@extends('layouts.app')

@section('title', 'Compatibility Assessment - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-3xl">

        <div class="text-center">
            <p class="font-semibold text-orange-500">
                Step 2
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                Compatibility Assessment
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                Review your saved compatibility answers for
                {{ $application->pet->name }}.
            </p>
        </div>

        <div class="mt-8 rounded-2xl bg-orange-100 p-5">
            <p class="text-sm text-gray-600">
                You are applying to adopt
            </p>

            <p class="mt-1 text-xl font-bold text-gray-900">
                {{ $application->pet->name }}
            </p>
        </div>

        <div class="mt-6 rounded-xl border border-orange-200 bg-white p-5">
            <p class="text-sm leading-6 text-gray-600">
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

        <form
            action="{{ route('compatibility-assessments.store', $application) }}"
            method="POST"
            class="mt-8 space-y-6 rounded-3xl bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf

            @foreach ($questions as $field => $label)

                <div class="{{ $loop->first ? '' : 'border-t border-gray-200 pt-6' }}">

                    <label class="font-semibold text-gray-900">
                        {{ $loop->iteration }}. {{ $label }}
                    </label>

                    <input
                        type="text"
                        value="{{ $profile?->$field ?? 'Not provided' }}"
                        disabled
                        class="mt-3 w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-600"
                    >

                </div>

            @endforeach

            <div class="border-t border-gray-200 pt-8">
                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500 px-8 py-3 font-semibold text-white hover:bg-orange-600"
                >
                    Calculate Compatibility
                </button>
            </div>

        </form>

    </div>

</section>

@endsection