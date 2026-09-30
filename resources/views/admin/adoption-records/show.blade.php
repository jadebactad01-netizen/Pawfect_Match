@extends('layouts.app')

@section('title', 'Adoption Record - Pawfect Match')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-5xl px-4 sm:px-6">

        <a href="{{ route('admin.adoption-records.index') }}"
           class="font-semibold text-orange-500
                  hover:text-orange-600">
            ← Back to Adoption Records
        </a>


        {{-- Heading --}}
        <div class="mt-6">

            <p class="font-semibold text-orange-500">
                Bayambang Animal Shelter
            </p>

            <div class="mt-2 flex flex-col gap-4
                        sm:flex-row sm:items-center
                        sm:justify-between">

                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Application #{{ $application->id }}
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Submitted
                        {{ $application->created_at->format('F d, Y') }}
                    </p>
                </div>


                <span class="w-fit rounded-full px-4 py-2
                             text-sm font-semibold

                    @if ($application->status === 'Approved')
                        bg-green-100 text-green-700

                    @elseif ($application->status === 'Rejected')
                        bg-red-100 text-red-700

                    @else
                        bg-yellow-100 text-yellow-700
                    @endif
                ">
                    {{ $application->status }}
                </span>

            </div>

        </div>


        {{-- Success message --}}
        @if (session('success'))

            <div class="mt-6 rounded-xl border border-green-200
                        bg-green-50 px-5 py-4 text-green-700">

                {{ session('success') }}

            </div>

        @endif


        {{-- Applicant --}}
        <div class="mt-8 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h2 class="text-xl font-bold text-gray-900">
                Applicant Information
            </h2>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">

                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->user->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Age</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->age }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="mt-1 break-words font-semibold">
                        {{ $application->user->email }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->user->adopterProfile->address }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Home Telephone</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->home_phone ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Work Telephone</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->work_phone ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Mobile Number</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->mobile_number }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Personal Reference --}}
        <div class="mt-6 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h2 class="text-xl font-bold text-gray-900">
                Personal Reference
            </h2>

            <div class="mt-6 grid gap-6 sm:grid-cols-3">

                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->reference_name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Relationship</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->reference_relationship }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Telephone</p>
                    <p class="mt-1 font-semibold">
                        {{ $application->reference_phone }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Shelter source --}}
        <div class="mt-6 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h2 class="text-xl font-bold text-gray-900">
                How They Heard About the Shelter
            </h2>

            <p class="mt-4 font-semibold text-gray-800">
                {{ $application->shelter_source }}

                @if ($application->shelter_source === 'Other')
                    — {{ $application->shelter_source_other }}
                @endif
            </p>

        </div>


        {{-- Animal preference --}}
        <div class="mt-6 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h2 class="text-xl font-bold text-gray-900">
                Animal Preference
            </h2>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">

                <div>
                    <p class="text-sm text-gray-500">
                        Interested In
                    </p>

                    <p class="mt-1 font-semibold">
                        {{ $application->animal_preference }}

                        @if ($application->animal_preference === 'Other')
                            — {{ $application->animal_preference_other }}
                        @endif
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Breed / Mix
                    </p>

                    <p class="mt-1 font-semibold">
                        {{ $application->preferred_breed ?: 'No preference' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Size
                    </p>

                    <p class="mt-1 font-semibold">
                        {{ $application->preferred_size ?: 'No preference' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Preferred Age
                    </p>

                    <p class="mt-1 font-semibold">
                        {{ $application->preferred_age ?: 'No preference' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Selected pet --}}
        <div class="mt-6 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h2 class="text-xl font-bold text-gray-900">
                Pet Applied For
            </h2>

            <div class="mt-5 rounded-2xl bg-orange-50 p-5">

                <p class="text-2xl font-bold text-gray-900">
                    {{ $application->pet->name }}
                </p>

                <p class="mt-2 text-gray-600">
                    {{ $application->pet->description }}
                </p>

                <a href="{{ route('pets.show', $application->pet) }}"
                   class="mt-4 inline-block font-semibold
                          text-orange-500 hover:text-orange-600">
                    View Pet →
                </a>

            </div>

        </div>


        <div class="mt-6 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h2 class="text-xl font-bold text-gray-900">
                Shelter Evaluation
            </h2>

            <div class="mt-6">

                <p class="text-sm text-gray-500">
                    Final Status
                </p>

                <p class="mt-1 font-semibold">
                    {{ $application->status }}
                </p>

            </div>

            <div class="mt-6">

                <p class="text-sm text-gray-500">
                    Evaluator's Notes
                </p>

                <p class="mt-1 whitespace-pre-line text-gray-800">
                    {{ $application->evaluator_notes
                        ?: 'No evaluator notes provided.' }}
                </p>

            </div>

        </div>

    </div>

</section>

@endsection