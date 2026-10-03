@extends('layouts.app')

@section('title', 'Adoption Application - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-4xl">

        {{-- Back --}}
        <a href="{{ route('pets.show', $pet) }}"
           class="font-semibold text-orange-500 hover:text-orange-600">
            ← Back to {{ $pet->name }}
        </a>


        {{-- Heading --}}
        <div class="mt-6 text-center">

            <p class="font-semibold uppercase tracking-wide text-orange-500">
                Bayambang Animal Shelter
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                Animal Adoption Application Form
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                Please provide the information requested by the shelter
                for your application to adopt {{ $pet->name }}.
            </p>

        </div>


        {{-- Important shelter notice --}}
        <div class="mt-8 rounded-2xl border border-orange-200
                    bg-orange-100 p-5 text-sm leading-6 text-gray-700">

            You will still need to have an interview with an adoption
            counselor before approval of your application. Completing
            this online form does not substitute for the shelter's
            in-person interview.

        </div>


        {{-- Errors --}}
        @if ($errors->any())

            <div class="mt-6 rounded-xl border border-red-200
                        bg-red-50 p-4 text-red-700">

                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <form
            action="{{ route('adoption-applications.store', $pet) }}"
            method="POST"
            class="mt-8 space-y-10 rounded-3xl bg-white
                   p-6 shadow-sm sm:p-8"
        >

            @csrf


            {{-- =====================================
                 APPLICATION INFORMATION
            ====================================== --}}

            <div>

                <h2 class="text-xl font-bold text-gray-900">
                    Application Information
                </h2>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    <div>
                        <p class="text-sm text-gray-500">
                            Date of Application
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ now()->format('F d, Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Pet Applying For
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $pet->name }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- =====================================
                APPLICANT INFORMATION
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <h2 class="text-xl font-bold text-gray-900">
                    Applicant Information
                </h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">

                    {{-- Name --}}
                    <div>
                        <label class="font-semibold text-gray-700">
                            Name
                        </label>

                        <input
                            type="text"
                            value="{{ auth()->user()->name }}"
                            disabled
                            class="mt-2 w-full rounded-xl border
                                border-gray-200 bg-gray-100
                                px-4 py-3 text-gray-600"
                        >
                    </div>

                    {{-- Age --}}
                    <div>
                        <label
                            for="age"
                            class="font-semibold text-gray-700"
                        >
                            Age
                        </label>

                        <input
                            type="number"
                            id="age"
                            name="age"
                            min="18"
                            max="120"
                            value="{{ old('age') }}"
                            required
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="font-semibold text-gray-700">
                            Email
                        </label>

                        <input
                            type="email"
                            value="{{ auth()->user()->email }}"
                            disabled
                            class="mt-2 w-full rounded-xl border
                                border-gray-200 bg-gray-100
                                px-4 py-3 text-gray-600"
                        >
                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="font-semibold text-gray-700">
                            Address
                        </label>

                        <input
                            type="text"
                            value="{{ auth()->user()->adopterProfile->address }}"
                            disabled
                            class="mt-2 w-full rounded-xl border
                                border-gray-200 bg-gray-100
                                px-4 py-3 text-gray-600"
                        >
                    </div>

                    {{-- Mobile Number --}}
                    <div class="sm:col-span-2">

                        <label
                            for="mobile_number"
                            class="font-semibold text-gray-700"
                        >
                            Mobile Number
                        </label>

                        <input
                            type="text"
                            id="mobile_number"
                            name="mobile_number"
                            inputmode="numeric"
                            maxlength="11"
                            pattern="[0-9]{11}"
                            value="{{ old(
                                'mobile_number',
                                auth()->user()->adopterProfile->phone_number
                            ) }}"
                            required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3"
                        >

                    </div>

                </div>

            </div>

            
            {{-- =====================================
                PERSONAL REFERENCE
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <h2 class="text-xl font-bold text-gray-900">
                    Personal Reference
                </h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-3">

                    <div>
                        <label
                            for="reference_name"
                            class="font-semibold text-gray-700"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            id="reference_name"
                            name="reference_name"
                            value="{{ old('reference_name') }}"
                            required
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3"
                        >
                    </div>

                    <div>
                        <label
                            for="reference_relationship"
                            class="font-semibold text-gray-700"
                        >
                            Relationship
                        </label>

                        <input
                            type="text"
                            id="reference_relationship"
                            name="reference_relationship"
                            value="{{ old('reference_relationship') }}"
                            required
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3"
                        >
                    </div>

                    <div>
                        <label
                            for="reference_phone"
                            class="font-semibold text-gray-700"
                        >
                            Mobile Number
                        </label>

                        <input
                            type="text"
                            id="reference_phone"
                            name="reference_phone"
                            inputmode="numeric"
                            maxlength="11"
                            pattern="[0-9]{11}"
                            value="{{ old('reference_phone') }}"
                            required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3"
                        >
                    </div>

                </div>

            </div>


            {{-- =====================================
                SHELTER SOURCE
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <label
                    for="shelter_source"
                    class="text-lg font-bold text-gray-900"
                >
                    What prompted you to come to Animal Shelter?
                </label>

                <select
                    id="shelter_source"
                    name="shelter_source"
                    required
                    onchange="
                        document.getElementById('shelter_source_other').disabled =
                            this.value !== 'Other';
                    "
                    class="mt-4 w-full rounded-xl border
                        border-gray-300 bg-white px-4 py-3"
                >

                    <option value="">Select an option</option>

                    @foreach (
                        ['Friends', 'Print Ads', 'TV Show', 'Website', 'Other']
                        as $source
                    )

                        <option
                            value="{{ $source }}"
                            @selected(old('shelter_source') === $source)
                        >
                            {{ $source }}
                        </option>

                    @endforeach

                </select>

                <div class="mt-4">

                    <label
                        for="shelter_source_other"
                        class="font-semibold text-gray-700"
                    >
                        If Other, please specify
                    </label>

                    <input
                        type="text"
                        id="shelter_source_other"
                        name="shelter_source_other"
                        value="{{ old('shelter_source_other') }}"
                        @disabled(old('shelter_source') !== 'Other')
                        class="mt-2 w-full rounded-xl border
                            border-gray-300 px-4 py-3
                            disabled:cursor-not-allowed
                            disabled:bg-gray-100
                            disabled:text-gray-400"
                    >

                </div>

            </div>


            {{-- =====================================
                ANIMAL INFORMATION
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <h2 class="text-xl font-bold text-gray-900">
                    Animal Preference
                </h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">

                    {{-- Interested in --}}
                    <div>
                        <label
                            for="animal_preference"
                            class="font-semibold text-gray-700"
                        >
                            Are you interested in a:
                        </label>

                        <select
                            id="animal_preference"
                            name="animal_preference"
                            required
                            onchange="
                                document.getElementById(
                                    'animal_preference_other'
                                ).disabled = this.value !== 'Other';
                            "
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 bg-white px-4 py-3"
                        >

                            <option value="">Select an option</option>

                            @foreach (
                                ['Cat', 'Kitten', 'Dog', 'Puppy', 'Other']
                                as $animal
                            )

                                <option
                                    value="{{ $animal }}"
                                    @selected(
                                        old('animal_preference') === $animal
                                    )
                                >
                                    {{ $animal }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    {{-- Other --}}
                    <div>
                        <label
                            for="animal_preference_other"
                            class="font-semibold text-gray-700"
                        >
                            If Other, please specify
                        </label>

                        <input
                            type="text"
                            id="animal_preference_other"
                            name="animal_preference_other"
                            value="{{ old('animal_preference_other') }}"
                            @disabled(old('animal_preference') !== 'Other')
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3
                                disabled:cursor-not-allowed
                                disabled:bg-gray-100
                                disabled:text-gray-400"
                        >
                    </div>

                    {{-- Breed --}}
                    <div>
                        <label
                            for="preferred_breed"
                            class="font-semibold text-gray-700"
                        >
                            Breed / Mix
                        </label>

                        <input
                            type="text"
                            id="preferred_breed"
                            name="preferred_breed"
                            value="{{ old('preferred_breed') }}"
                            oninput="
                                this.value =
                                    this.value.replace(/[^a-zA-Z\s-]/g, '')
                            "
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 px-4 py-3"
                        >
                    </div>

                    {{-- Size --}}
                    <div>
                        <label
                            for="preferred_size"
                            class="font-semibold text-gray-700"
                        >
                            Preferred Size
                        </label>

                        <select
                            id="preferred_size"
                            name="preferred_size"
                            class="mt-2 w-full rounded-xl border
                                border-gray-300 bg-white px-4 py-3"
                        >

                            <option value="">Select size</option>

                            @foreach (
                                ['Small', 'Medium', 'Large', 'Extra Large']
                                as $size
                            )

                                <option
                                    value="{{ $size }}"
                                    @selected(old('preferred_size') === $size)
                                >
                                    {{ $size }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    {{-- Preferred Age --}}
                    <div>
                        <label
                            for="preferred_age"
                            class="font-semibold text-gray-700"
                        >
                            Preferred Age
                        </label>

                        <div class="mt-2 flex gap-3">

                            <input
                                type="text"
                                id="preferred_age"
                                name="preferred_age"
                                inputmode="numeric"
                                maxlength="2"
                                value="{{ old('preferred_age') }}"
                                placeholder="Age"
                                oninput="
                                    this.value = this.value.replace(/[^0-9]/g, '');

                                    if (
                                        document.getElementById('preferred_age_unit').value === 'Months'
                                        && Number(this.value) > 11
                                    ) {
                                        this.value = '11';
                                    }

                                    if (
                                        document.getElementById('preferred_age_unit').value === 'Years'
                                        && Number(this.value) > 30
                                    ) {
                                        this.value = '30';
                                    }
                                "
                                class="w-full rounded-xl border
                                    border-gray-300 px-4 py-3"
                            >

                            <select
                                id="preferred_age_unit"
                                name="preferred_age_unit"
                                onchange="
                                    document.getElementById('preferred_age').value = '';
                                "
                                class="rounded-xl border border-gray-300
                                    bg-white px-4 py-3"
                            >

                                <option
                                    value="Months"
                                    @selected(
                                        old('preferred_age_unit', 'Months') === 'Months'
                                    )
                                >
                                    Months
                                </option>

                                <option
                                    value="Years"
                                    @selected(
                                        old('preferred_age_unit') === 'Years'
                                    )
                                >
                                    Years
                                </option>

                            </select>

                        </div>

                        <p class="mt-2 text-sm text-gray-500">
                            Months: 1–11 • Years: 1–30
                        </p>
                    </div>

                    {{-- Selected Animal --}}
                    <div>
                        <label class="font-semibold text-gray-700">
                            Name / Description of Animal
                        </label>

                        <div class="mt-2 rounded-xl border
                                    border-orange-200 bg-orange-50
                                    px-4 py-3">

                            <p class="font-bold text-gray-900">
                                {{ $pet->name }}
                            </p>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $pet->description }}
                            </p>

                        </div>
                    </div>

                </div>

            </div>


            {{-- =====================================
                 AGREEMENT NOTICE
            ====================================== --}}

            <div class="border-t border-gray-200 pt-8">

                <div class="rounded-2xl bg-gray-50 p-5">

                    <h2 class="font-bold text-gray-900">
                        Adoption Agreement
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        The Bayambang Animal Shelter adoption agreement
                        is completed separately on the day of adoption.
                        It is not part of this initial application.
                    </p>

                </div>

            </div>


            {{-- Submit --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row
                        sm:items-center sm:justify-end">

                <a href="{{ route('pets.show', $pet) }}"
                   class="rounded-full border border-gray-300
                          px-7 py-3 text-center font-semibold
                          text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-full bg-orange-500
                           px-8 py-3 font-semibold text-white
                           hover:bg-orange-600"
                >
                    Continue to Compatibility Assessment
                </button>

            </div>

        </form>

    </div>

</section>

@endsection