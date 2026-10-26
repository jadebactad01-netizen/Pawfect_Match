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
                Review your lifestyle answers to determine your
                compatibility with {{ $application->pet->name }}.
            </p>
        </div>

        {{-- SELECTED PET --}}
        <div class="mt-8 rounded-2xl bg-orange-100 p-5">
            <p class="text-sm text-gray-600">
                You are applying to adopt
            </p>

            <p class="mt-1 text-xl font-bold text-gray-900">
                {{ $application->pet->name }}
            </p>
        </div>

        {{-- INFORMATION --}}
        <div class="mt-6 rounded-xl border border-orange-200 bg-white p-5">
            <p class="text-sm leading-6 text-gray-600">
                Your answers are automatically filled using your
                adopter profile. Please review them before submitting.
                You can still change your answers for this application.
            </p>
        </div>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
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

        @php
            $profile = auth()->user()->adopterProfile;

            $questions = [
                'care_ability' => [
                    'Ability to Provide Proper Care',
                    'How would you describe your ability to provide food, veterinary care, grooming, and other needs?',
                    ['Limited', 'Moderate', 'High'],
                ],

                'available_time' => [
                    'Available Time',
                    'How much time can you regularly give to a pet?',
                    ['Low', 'Moderate', 'High'],
                ],

                'household_compatibility' => [
                    'Household',
                    'Which best describes your household?',
                    ['Living alone', 'Adults only', 'Family with children'],
                ],

                'living_environment' => [
                    'Living Environment',
                    'What type of home do you currently live in?',
                    ['House', 'Apartment', 'Other'],
                ],

                'pet_care_experience' => [
                    'Pet-care Experience',
                    'How much experience do you have caring for pets?',
                    ['None', 'Some', 'Experienced'],
                ],

                'activity_level' => [
                    'Activity Level',
                    'How would you describe your normal activity level?',
                    ['Low', 'Moderate', 'High'],
                ],
            ];
        @endphp

        <form
            action="{{ route('compatibility-assessments.store', $application) }}"
            method="POST"
            class="mt-8 space-y-8 rounded-3xl bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf

            @foreach ($questions as $field => $question)

                <div class="{{ $loop->first ? '' : 'border-t border-gray-200 pt-8' }}">

                    <label
                        for="{{ $field }}"
                        class="text-lg font-bold text-gray-900"
                    >
                        {{ $loop->iteration }}. {{ $question[0] }}
                    </label>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $question[1] }}
                    </p>

                    <select
                        id="{{ $field }}"
                        name="{{ $field }}"
                        required
                        class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
                    >
                        <option value="">Select an answer</option>

                        @foreach ($question[2] as $option)
                            <option
                                value="{{ $option }}"
                                @selected(old($field, $profile?->$field) === $option)
                            >
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>

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