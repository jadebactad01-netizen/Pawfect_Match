@extends('layouts.app')

@section('title', 'Add Pet - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Add a Pet
            </h1>

            <p class="mt-2 text-sm leading-6 text-gray-600">
                Enter the pet's information, health details, and compatibility requirements.
            </p>

            <a
                href="{{ route('admin.pets.manage') }}"
                class="mt-4 inline-flex items-center text-sm font-semibold text-orange-600 hover:text-orange-700"
            >
                ← Back to Manage Pets
            </a>

        </div>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700">

                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        {{-- ADD PET FORM --}}
        <form
            action="{{ route('admin.pets.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf

            {{-- BASIC INFORMATION --}}
            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <div class="border-b border-orange-100 pb-4">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Pet Information
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Basic Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Provide the pet's basic details and current availability.
                    </p>

                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    {{-- PET NAME --}}
                    <div class="sm:col-span-2">

                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            Pet Name <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            maxlength="255"
                            placeholder="Enter pet name"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                    {{-- PET TYPE --}}
                    <div>

                        <label for="type" class="block text-sm font-semibold text-gray-700">
                            Type <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="type"
                            name="type"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            <option value="">Select type</option>

                            @foreach (['Dog', 'Cat'] as $option)
                                <option
                                    value="{{ $option }}"
                                    @selected(old('type') === $option)
                                >
                                    {{ $option }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- SEX --}}
                    <div>

                        <label for="sex" class="block text-sm font-semibold text-gray-700">
                            Sex <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="sex"
                            name="sex"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            <option value="">Select sex</option>

                            @foreach (['Male', 'Female'] as $option)
                                <option
                                    value="{{ $option }}"
                                    @selected(old('sex') === $option)
                                >
                                    {{ $option }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- AGE --}}
                    <div>

                        <label for="age_number" class="block text-sm font-semibold text-gray-700">
                            Age <span class="text-red-500">*</span>
                        </label>

                        <div class="mt-2 flex gap-3">

                            <input
                                type="text"
                                id="age_number"
                                name="age_number"
                                inputmode="numeric"
                                maxlength="2"
                                value="{{ old('age_number') }}"
                                placeholder="Age"
                                required
                                oninput="
                                    this.value = this.value.replace(/[^0-9]/g, '');
                                    let limit = document.getElementById('age_unit').value === 'Months' ? 11 : 30;
                                    if (Number(this.value) > limit) this.value = limit;
                                "
                                class="min-w-0 flex-1 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >

                            <select
                                id="age_unit"
                                name="age_unit"
                                required
                                onchange="document.getElementById('age_number').value = ''"
                                class="rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >

                                @foreach (['Months', 'Years'] as $unit)
                                    <option
                                        value="{{ $unit }}"
                                        @selected(old('age_unit', 'Months') === $unit)
                                    >
                                        {{ $unit }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            Months: 1–11 | Years: 1–30
                        </p>

                    </div>

                    {{-- ADOPTION STATUS --}}
                    <div>

                        <label for="status" class="block text-sm font-semibold text-gray-700">
                            Adoption Status <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            @foreach (['Available', 'Unavailable'] as $option)
                                <option
                                    value="{{ $option }}"
                                    @selected(old('status', 'Available') === $option)
                                >
                                    {{ $option }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

            {{-- PET INTAKE DETAILS --}}
            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <div class="border-b border-orange-100 pb-4">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Shelter Records
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Pet Intake Details
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Record how the animal arrived at the shelter.
                    </p>

                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    {{-- PET ORIGIN --}}
                    <div>

                        <label for="intake_type" class="block text-sm font-semibold text-gray-700">
                            Pet Origin
                        </label>

                        <select
                            id="intake_type"
                            name="intake_type"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            <option value="">Select origin</option>

                            @foreach (['Rescued', 'Surrendered'] as $option)
                                <option
                                    value="{{ $option }}"
                                    @selected(old('intake_type') === $option)
                                >
                                    {{ $option }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- INTAKE DATE --}}
                    <div>

                        <label for="intake_date" class="block text-sm font-semibold text-gray-700">
                            Date Rescued / Surrendered
                        </label>

                        <input
                            type="date"
                            id="intake_date"
                            name="intake_date"
                            max="{{ now()->toDateString() }}"
                            value="{{ old('intake_date') }}"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-500">
                    If you provide an origin, you must also provide the corresponding intake date.
                </p>

            </div>

            {{-- VACCINATION DETAILS --}}
            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <div class="border-b border-orange-100 pb-4">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Health Information
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Vaccination Details
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Provide the pet's vaccination information, if available.
                    </p>

                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    {{-- VACCINATION TYPE --}}
                    <div>

                        <label for="vaccination_type" class="block text-sm font-semibold text-gray-700">
                            Vaccination Type
                        </label>

                        <input
                            type="text"
                            id="vaccination_type"
                            name="vaccination_type"
                            value="{{ old('vaccination_type') }}"
                            maxlength="255"
                            placeholder="e.g., Anti-Rabies"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                    {{-- VACCINATION DATE --}}
                    <div>

                        <label for="vaccination_date" class="block text-sm font-semibold text-gray-700">
                            Vaccination Date
                        </label>

                        <input
                            type="date"
                            id="vaccination_date"
                            name="vaccination_date"
                            max="{{ now()->toDateString() }}"
                            value="{{ old('vaccination_date') }}"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-500">
                    Leave both fields blank if the vaccination information is unavailable.
                </p>

            </div>

            {{-- PET PHOTO AND DESCRIPTION --}}
            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <div class="border-b border-orange-100 pb-4">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Pet Profile
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Photo and Description
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Add a photo and description to help adopters learn about the pet.
                    </p>

                </div>

                <div class="mt-5 space-y-5">

                    {{-- PET PHOTO --}}
                    <div>

                        <label for="photo" class="block text-sm font-semibold text-gray-700">
                            Pet Photo
                        </label>

                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/jpeg,image/png,image/webp"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-600 file:mr-4 file:rounded-full file:border-0 file:bg-orange-100 file:px-4 file:py-2 file:font-semibold file:text-orange-700 hover:file:bg-orange-200"
                        >

                        <p class="mt-2 text-xs text-gray-500">
                            JPG, PNG, or WebP. Maximum 5 MB.
                        </p>

                    </div>

                    {{-- DESCRIPTION --}}
                    <div>

                        <label for="description" class="block text-sm font-semibold text-gray-700">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Describe the pet's personality, behavior, and other important information..."
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >{{ old('description') }}</textarea>

                    </div>

                </div>

            </div>

            {{-- COMPATIBILITY REQUIREMENTS --}}
            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <div class="border-b border-orange-100 pb-4">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Matching Criteria
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Compatibility Requirements
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Specify the adopter and living environment best suited for this pet.
                    </p>

                </div>

                @php
                    $requirements = [
                        'care_requirement' => [
                            'Care Requirement',
                            ['Low', 'Moderate', 'High'],
                        ],
                        'time_requirement' => [
                            'Time Requirement',
                            ['Low', 'Moderate', 'High'],
                        ],
                        'household_compatibility' => [
                            'Household Compatibility',
                            ['Living alone', 'Adults only', 'Family with children', 'Any'],
                        ],
                        'living_environment' => [
                            'Living Environment',
                            ['House', 'Apartment', 'Other', 'Any'],
                        ],
                        'experience_requirement' => [
                            'Pet Care Experience Required',
                            ['None', 'Some', 'Experienced'],
                        ],
                        'activity_level' => [
                            'Activity Level',
                            ['Low', 'Moderate', 'High'],
                        ],
                    ];
                @endphp

                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    @foreach ($requirements as $field => $config)

                        <div>

                            <label
                                for="{{ $field }}"
                                class="block text-sm font-semibold text-gray-700"
                            >
                                {{ $config[0] }} <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="{{ $field }}"
                                name="{{ $field }}"
                                required
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >

                                <option value="">Select option</option>

                                @foreach ($config[1] as $option)

                                    <option
                                        value="{{ $option }}"
                                        @selected(old($field) === $option)
                                    >
                                        {{ $option === 'None' ? 'No experience required' : $option }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- FORM ACTIONS --}}
            <div class="flex flex-col-reverse gap-3 rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-end">

                <a
                    href="{{ route('admin.pets.manage') }}"
                    class="rounded-full border border-orange-200 bg-white px-7 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-full bg-orange-500 px-8 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Add Pet
                </button>

            </div>

        </form>

    </div>

</section>

@endsection