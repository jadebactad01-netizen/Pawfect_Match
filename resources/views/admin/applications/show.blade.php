
@extends('layouts.app')

@section('title', 'Review Application - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
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

            <p class="mt-3 text-sm text-gray-600">
                Review the adopter's information, pet selection, and application evaluation.
            </p>

            <a
                href="{{ route('admin.applications.index') }}"
                class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
            >
                ← Back to Applications
            </a>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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

                <p class="mt-1 text-sm text-gray-500">
                    Personal and contact details provided by the adopter.
                </p>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-sm font-semibold text-gray-500">Full Name</p>
                    <p class="mt-1 break-words text-sm font-medium text-gray-900">
                        {{ $application->user?->name ?? 'Unavailable' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Age</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->age ?? 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Email Address</p>
                    <p class="mt-1 break-all text-sm font-medium text-gray-900">
                        {{ $application->user?->email ?? 'Unavailable' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Mobile Number</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->mobile_number ?: 'Not provided' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-sm font-semibold text-gray-500">Address</p>
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

                <p class="mt-1 text-sm text-gray-500">
                    Reference information supplied by the applicant.
                </p>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-3">

                <div>
                    <p class="text-sm font-semibold text-gray-500">Name</p>
                    <p class="mt-1 break-words text-sm font-medium text-gray-900">
                        {{ $application->reference_name ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Relationship</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->reference_relationship ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Telephone</p>
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

                    @if ($application->shelter_source === 'Other' && $application->shelter_source_other)
                        — {{ $application->shelter_source_other }}
                    @endif
                </p>

            </div>

        </div>

        {{-- ANIMAL PREFERENCES --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Adoption Preferences
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Animal Preference
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    The type of animal and characteristics preferred by the adopter.
                </p>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-sm font-semibold text-gray-500">Interested In</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->animal_preference ?: 'No preference' }}

                        @if ($application->animal_preference === 'Other' && $application->animal_preference_other)
                            — {{ $application->animal_preference_other }}
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Breed / Mix</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->preferred_breed ?: 'No preference' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Size</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->preferred_size ?: 'No preference' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Preferred Age</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $application->preferred_age ?: 'No preference' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- SELECTED PET --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="border-b border-orange-100 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Pet Selection
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Pet Applied For
                </h2>
            </div>

            <div class="mt-5 flex flex-col gap-5 rounded-xl border border-orange-100 bg-orange-50/50 p-4 sm:flex-row sm:items-start sm:p-5">

                @if ($application->pet?->photo)
                    <img
                        src="{{ asset('storage/' . $application->pet->photo) }}"
                        alt="{{ $application->pet->name }}"
                        class="h-32 w-full rounded-xl object-cover sm:h-28 sm:w-28"
                    >
                @endif

                <div class="min-w-0 flex-1">

                    <h3 class="text-xl font-bold text-gray-900">
                        {{ $application->pet?->name ?? 'Pet unavailable' }}
                    </h3>

                    @if ($application->pet)
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $application->pet->type }} · {{ $application->pet->sex }} · {{ $application->pet->age }}
                        </p>

                        <p class="mt-3 whitespace-pre-line break-words text-sm leading-6 text-gray-600">{{ $application->pet->description ?: 'No description provided.' }}</p>

                        <a
                            href="{{ route('pets.show', $application->pet) }}"
                            class="mt-3 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
                        >
                            View Pet →
                        </a>
                    @endif

                </div>

            </div>

        </div>

        {{-- SHELTER EVALUATION --}}
        <form
            action="{{ route('admin.applications.update', $application) }}"
            method="POST"
            class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8"
        >

            @csrf
            @method('PUT')

            <div class="border-b border-orange-100 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Administrative Review
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Shelter Evaluation
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Record your evaluation notes and select the application's status.
                </p>
            </div>

            {{-- EVALUATOR NOTES --}}
            <div class="mt-5">

                <label
                    for="evaluator_notes"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Evaluator's Notes
                </label>

                <textarea
                    id="evaluator_notes"
                    name="evaluator_notes"
                    rows="5"
                    maxlength="5000"
                    placeholder="Enter interview or evaluation notes here..."
                    class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                >{{ old('evaluator_notes', $application->evaluator_notes) }}</textarea>

                @error('evaluator_notes')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- APPLICATION STATUS --}}
            <div class="mt-5">

                <label
                    for="status"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Application Status <span class="text-red-500">*</span>
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                >
                    @foreach (['Pending', 'Approved', 'Rejected'] as $status)
                        <option
                            value="{{ $status }}"
                            @selected(old('status', $application->status) === $status)
                        >
                            {{ $status }}
                        </option>
                    @endforeach
                </select>

                @error('status')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <p class="mt-2 text-xs leading-5 text-gray-500">
                    Approving an application marks the pet as adopted.
                    Rejecting it makes the pet available again.
                </p>

            </div>

            {{-- FORM ACTIONS --}}
            <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-orange-100 pt-5">

                <a
                    href="{{ route('admin.applications.index') }}"
                    class="rounded-full border border-orange-200 bg-white px-6 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                >
                    Back
                </a>

                <button
                    type="submit"
                    class="rounded-full bg-orange-500 px-8 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Save Review
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
