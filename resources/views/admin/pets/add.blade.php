@extends('layouts.app')

@section('title', 'Add Pet - Pawfect Match')

@section('content')

<section class="bg-orange-50 py-12">
    <div class="mx-auto max-w-3xl px-6">

        <a href="{{ route('admin.pets.manage') }}"
           class="font-semibold text-orange-500 hover:text-orange-600">
            ← Back to Manage Pets
        </a>

        <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm sm:p-10">

            <p class="font-semibold text-orange-500">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Add a Pet
            </h1>

            <p class="mt-3 text-gray-600">
                Enter the pet's information and compatibility requirements below.
            </p>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl bg-red-50 p-5 text-red-700">
                    <p class="font-semibold">
                        Please check the information below.
                    </p>

                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pets.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="mt-8 space-y-6">

                @csrf

                {{-- PET NAME --}}
                <div>
                    <label for="name" class="font-semibold text-gray-700">
                        Pet Name
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3">
                </div>

                {{-- TYPE AND SEX --}}
                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label for="type" class="font-semibold text-gray-700">
                            Type
                        </label>

                        <select id="type" name="type" required
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3">
                            <option value="">Select type</option>

                            @foreach (['Dog', 'Cat'] as $option)
                                <option value="{{ $option }}"
                                    @selected(old('type') === $option)>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sex" class="font-semibold text-gray-700">
                            Sex
                        </label>

                        <select id="sex" name="sex" required
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3">
                            <option value="">Select sex</option>

                            @foreach (['Male', 'Female'] as $option)
                                <option value="{{ $option }}"
                                    @selected(old('sex') === $option)>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- AGE --}}
                <div>
                    <label for="age_number" class="font-semibold text-gray-700">
                        Age
                    </label>

                    <div class="mt-2 flex gap-3">
                        <input type="text"
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
                               class="min-w-0 flex-1 rounded-xl border border-gray-300 px-4 py-3">

                        <select id="age_unit"
                                name="age_unit"
                                required
                                onchange="document.getElementById('age_number').value = ''"
                                class="rounded-xl border border-gray-300 bg-white px-4 py-3">

                            @foreach (['Months', 'Years'] as $unit)
                                <option value="{{ $unit }}"
                                    @selected(old('age_unit', 'Months') === $unit)>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <p class="mt-2 text-sm text-gray-500">
                        Months: 1–11 • Years: 1–30
                    </p>
                </div>

                {{-- ADOPTION STATUS --}}
                <div>
                    <label for="status" class="font-semibold text-gray-700">
                        Adoption Status
                    </label>

                    <select id="status" name="status" required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3">

                        @foreach (['Available', 'Unavailable'] as $option)
                            <option value="{{ $option }}"
                                @selected(old('status', 'Available') === $option)>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NEW: PET INTAKE --}}
                <div class="border-t border-gray-200 pt-8">

                    <h2 class="text-xl font-bold text-gray-900">
                        Pet Intake Details
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Indicate whether the animal was rescued or surrendered,
                        and enter the corresponding date.
                    </p>

                    <div class="mt-5 grid gap-6 sm:grid-cols-2">

                        <div>
                            <label for="intake_type" class="font-semibold text-gray-700">
                                Pet Origin
                            </label>

                            <select id="intake_type"
                                    name="intake_type"
                                    class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3">
                                <option value="">Select origin</option>

                                @foreach (['Rescued', 'Surrendered'] as $option)
                                    <option value="{{ $option }}"
                                        @selected(old('intake_type') === $option)>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="intake_date" class="font-semibold text-gray-700">
                                Date Rescued / Surrendered
                            </label>

                            <input type="date"
                                   id="intake_date"
                                   name="intake_date"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ old('intake_date') }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3">
                        </div>

                    </div>
                </div>

                {{-- NEW: VACCINATION --}}
                <div class="border-t border-gray-200 pt-8">

                    <h2 class="text-xl font-bold text-gray-900">
                        Vaccination Details
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Enter the vaccine administered and its date.
                        Leave both blank if the vaccination details are unavailable.
                    </p>

                    <div class="mt-5 grid gap-6 sm:grid-cols-2">

                        <div>
                            <label for="vaccination_type" class="font-semibold text-gray-700">
                                Vaccination Type
                            </label>

                            <input type="text"
                                   id="vaccination_type"
                                   name="vaccination_type"
                                   value="{{ old('vaccination_type') }}"
                                   placeholder="e.g., Anti-Rabies"
                                   class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3">
                        </div>

                        <div>
                            <label for="vaccination_date" class="font-semibold text-gray-700">
                                Vaccination Date
                            </label>

                            <input type="date"
                                   id="vaccination_date"
                                   name="vaccination_date"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ old('vaccination_date') }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3">
                        </div>

                    </div>
                </div>

                {{-- PHOTO --}}
                <div class="border-t border-gray-200 pt-8">
                    <label for="photo" class="font-semibold text-gray-700">
                        Pet Photo
                    </label>

                    <input type="file"
                           id="photo"
                           name="photo"
                           accept="image/jpeg,image/png,image/webp"
                           class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3">

                    <p class="mt-2 text-sm text-gray-500">
                        JPG, PNG, or WebP. Maximum 5 MB.
                    </p>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label for="description" class="font-semibold text-gray-700">
                        Description
                    </label>

                    <textarea id="description"
                              name="description"
                              rows="5"
                              class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3">{{ old('description') }}</textarea>
                </div>

                {{-- COMPATIBILITY REQUIREMENTS --}}
                <div class="border-t border-gray-200 pt-8">

                    <h2 class="text-xl font-bold text-gray-900">
                        Compatibility Requirements
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Describe the adopter and home environment
                        that may be suitable for this pet.
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

                <div class="grid gap-6 sm:grid-cols-2">

                    @foreach ($requirements as $field => $config)
                        <div>
                            <label for="{{ $field }}" class="font-semibold text-gray-700">
                                {{ $config[0] }}
                            </label>

                            <select id="{{ $field }}"
                                    name="{{ $field }}"
                                    required
                                    class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3">

                                <option value="">Select option</option>

                                @foreach ($config[1] as $option)
                                    <option value="{{ $option }}"
                                        @selected(old($field) === $option)>
                                        {{ $option === 'None' ? 'No experience required' : ($option === 'Any' ? 'Any' : $option) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                </div>

                <button type="submit"
                        class="w-full rounded-full bg-orange-500 px-6 py-3 font-semibold text-white hover:bg-orange-600">
                    Add Pet
                </button>

            </form>
        </div>
    </div>
</section>

@endsection