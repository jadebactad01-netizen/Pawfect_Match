
@extends('layouts.app')

@section('title', 'Adoption Record - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Bayambang Animal Shelter
            </p>

            <div class="mt-2 flex flex-wrap items-center justify-between gap-4">

                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Application #{{ $application->id }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-600">
                        Submitted {{ $application->created_at->format('F d, Y') }}
                    </p>
                </div>

                <span class="rounded-full border px-4 py-2 text-sm font-semibold
                    @if ($application->status === 'Approved')
                        border-green-200 bg-green-50 text-green-700
                    @elseif ($application->status === 'Rejected')
                        border-red-200 bg-red-50 text-red-700
                    @else
                        border-amber-200 bg-amber-50 text-amber-700
                    @endif"
                >
                    {{ $application->status }}
                </span>

            </div>

            <a
                href="{{ route('admin.adoption-records.index') }}"
                class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
            >
                ← Back to Adoption Records
            </a>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- APPLICANT INFORMATION --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Applicant Profile
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Applicant Information
                </h2>

            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Name
                    </p>

                    <p class="mt-1 break-words text-sm font-medium text-gray-900">
                        {{ $application->user?->name ?? 'Unavailable' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Age
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->age ?? 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Email
                    </p>

                    <p class="mt-1 break-all text-sm font-medium text-gray-900">
                        {{ $application->user?->email ?? 'Unavailable' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Mobile Number
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->mobile_number ?: 'Not provided' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-sm font-semibold text-gray-500">
                        Address
                    </p>

                    <p class="mt-1 break-words text-sm font-medium leading-6 text-gray-900">
                        {{ $application->user?->adopterProfile?->address ?? 'Not provided' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- PERSONAL REFERENCE --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Contact Reference
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Personal Reference
                </h2>

            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-3">

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Name
                    </p>

                    <p class="mt-1 break-words text-sm font-medium text-gray-900">
                        {{ $application->reference_name ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Relationship
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->reference_relationship ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Telephone
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->reference_phone ?: 'Not provided' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- SHELTER SOURCE --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                Registration Information
            </p>

            <h2 class="mt-1 text-xl font-bold text-gray-900">
                How They Heard About the Shelter
            </h2>

            <div class="mt-4 rounded-xl border border-orange-100 bg-orange-50/50 px-5 py-4">

                <p class="text-sm font-medium text-gray-900">
                    {{ $application->shelter_source ?: 'Not provided' }}

                    @if ($application->shelter_source === 'Other')
                        — {{ $application->shelter_source_other }}
                    @endif
                </p>

            </div>

        </div>

        {{-- ANIMAL PREFERENCE --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Adoption Preferences
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Animal Preference
                </h2>

            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Interested In
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->animal_preference ?: 'No preference' }}

                        @if ($application->animal_preference === 'Other')
                            — {{ $application->animal_preference_other }}
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Breed / Mix
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->preferred_breed ?: 'No preference' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Size
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->preferred_size ?: 'No preference' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Preferred Age
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->preferred_age ?: 'No preference' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- PET APPLIED FOR --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Pet Selection
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Pet Applied For
                </h2>

            </div>

            <div class="mt-5 rounded-xl border border-orange-100 bg-orange-50/50 p-5">

                <h3 class="text-xl font-bold text-gray-900">
                    {{ $application->pet?->name ?? 'Pet unavailable' }}
                </h3>

                <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-gray-600">{{ $application->pet?->description ?: 'No description provided.' }}</p>

                @if ($application->pet)
                    <a
                        href="{{ route('pets.show', $application->pet) }}"
                        class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
                    >
                        View Pet →
                    </a>
                @endif

            </div>

        </div>

        {{-- SHELTER EVALUATION --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Evaluation Result
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Shelter Evaluation
                </h2>

            </div>

            <div class="mt-5">

                <p class="text-sm font-semibold text-gray-500">
                    Final Status
                </p>

                <p class="mt-2">

                    <span class="inline-block rounded-full border px-3 py-1 text-xs font-semibold
                        {{ $application->status === 'Approved'
                            ? 'border-green-200 bg-green-50 text-green-700'
                            : 'border-red-200 bg-red-50 text-red-700' }}"
                    >
                        {{ $application->status }}
                    </span>

                </p>

            </div>

            <div class="mt-5">

                <p class="text-sm font-semibold text-gray-500">
                    Evaluator's Notes
                </p>

                <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-gray-800">
                    {{ $application->evaluator_notes ?: 'No evaluator notes provided.' }}
                </p>

            </div>

        </div>

    </div>

</section>

@endsection
