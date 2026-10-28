@extends('layouts.app')

@section('title', 'Adoption Application - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-4xl">

        {{-- BACK BUTTON --}}
        <a
            href="{{ route('pets.show', $pet) }}"
            class="inline-flex items-center gap-2 rounded-full border border-orange-200 bg-white px-4 py-2 text-sm font-semibold text-orange-600 transition duration-200 hover:border-orange-300 hover:bg-orange-50"
        >
            <span>←</span>
            <span>Back to {{ $pet->name }}</span>
        </a>

        {{-- PAGE HEADER --}}
        <div class="relative mt-6 overflow-hidden rounded-3xl border border-orange-200 bg-orange-100 px-6 py-8 text-center sm:px-8">

            <div class="relative">

                <p class="text-sm font-semibold uppercase tracking-wider text-orange-500">
                    Bayambang Animal Shelter
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                    Animal Adoption Application Form
                </h1>

                <div class="mx-auto mt-4 h-1 w-14 rounded-full bg-orange-400"></div>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                    Please provide the information requested by the shelter
                    for your application to adopt {{ $pet->name }}.
                </p>

            </div>

        </div>

        {{-- IMPORTANT REMINDER --}}
        <div class="mt-6 rounded-2xl border border-orange-200 bg-orange-100/60 p-5">

            <p class="text-sm font-semibold text-orange-700">
                Important Reminder
            </p>

            <p class="mt-2 text-sm leading-7 text-gray-700">
                You will still need to have an interview with the shelter's
                staff before the approval of your application. Completing
                this online form does not substitute for the shelter's
                in-person interview.
            </p>

        </div>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700">

                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-3 list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        @php
            $profile = auth()->user()->adopterProfile;
        @endphp

        {{-- APPLICATION FORM --}}
        <form
            action="{{ route('adoption-applications.store', $pet) }}"
            method="POST"
            class="mt-8 space-y-8 rounded-3xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf

            {{-- APPLICATION INFORMATION --}}
            <div>

                <div class="mb-5">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Application Details
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Application Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Details of your current adoption application.
                    </p>

                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-orange-100 bg-orange-50/60 p-4">

                        <p class="text-sm text-gray-500">
                            Date of Application
                        </p>

                        <p class="mt-2 font-semibold text-gray-900">
                            {{ now()->format('F d, Y') }}
                        </p>

                    </div>

                    <div class="rounded-xl border border-orange-100 bg-orange-50/60 p-4">

                        <p class="text-sm text-gray-500">
                            Pet Applying For
                        </p>

                        <p class="mt-2 font-semibold text-gray-900">
                            {{ $pet->name }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- APPLICANT INFORMATION --}}
            <div class="border-t border-orange-100 pt-8">

                <div class="mb-6">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Personal Details
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Applicant Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        The following information is taken from your adopter profile.
                    </p>

                </div>

                <div class="grid gap-5 sm:grid-cols-2">

                    @foreach ([
                        'Name' => auth()->user()->name,
                        'Age' => $profile->age,
                        'Email' => auth()->user()->email,
                        'Address' => $profile->address,
                        'Mobile Number' => $profile->phone_number,
                    ] as $label => $value)

                        <div>

                            <label class="text-sm font-semibold text-gray-700">
                                {{ $label }}
                            </label>

                            <input
                                type="text"
                                value="{{ $value }}"
                                disabled
                                class="mt-2 w-full rounded-xl border border-orange-100 bg-orange-50/40 px-4 py-3 text-gray-600"
                            >

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- PERSONAL REFERENCE --}}
            <div class="border-t border-orange-100 pt-8">

                <div class="mb-6">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Reference Details
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Personal Reference
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Provide the contact details of your personal reference.
                    </p>

                </div>

                <div class="grid gap-5 sm:grid-cols-3">

                    {{-- REFERENCE NAME --}}
                    <div>

                        <label
                            for="reference_name"
                            class="text-sm font-semibold text-gray-700"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            id="reference_name"
                            name="reference_name"
                            required
                            value="{{ old('reference_name') }}"
                            oninput="this.value = this.value.replace(/[^\p{L}\s.'-]/gu, '')"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition duration-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                    {{-- RELATIONSHIP --}}
                    <div>

                        <label
                            for="reference_relationship"
                            class="text-sm font-semibold text-gray-700"
                        >
                            Relationship
                        </label>

                        <input
                            type="text"
                            id="reference_relationship"
                            name="reference_relationship"
                            required
                            value="{{ old('reference_relationship') }}"
                            oninput="this.value = this.value.replace(/[^\p{L}\s.'-]/gu, '')"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition duration-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                    {{-- REFERENCE PHONE --}}
                    <div>

                        <label
                            for="reference_phone"
                            class="text-sm font-semibold text-gray-700"
                        >
                            Mobile Number
                        </label>

                        <input
                            type="text"
                            id="reference_phone"
                            name="reference_phone"
                            inputmode="numeric"
                            maxlength="11"
                            required
                            value="{{ old('reference_phone') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition duration-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                </div>

            </div>

            {{-- SHELTER SOURCE --}}
            <div class="border-t border-orange-100 pt-8">

                <div class="mb-5">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Shelter Information
                    </p>

                    <label
                        for="shelter_source"
                        class="mt-1 block text-lg font-bold text-gray-900"
                    >
                        What prompted you to come to Animal Shelter?
                    </label>

                </div>

                <select
                    id="shelter_source"
                    name="shelter_source"
                    required
                    onchange="document.getElementById('shelter_source_other').disabled = this.value !== 'Other'"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition duration-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                >
                    <option value="">
                        Select an option
                    </option>

                    @foreach (['Friends', 'Facebook', 'Website', 'Other'] as $source)

                        <option
                            value="{{ $source }}"
                            @selected(old('shelter_source') === $source)
                        >
                            {{ $source }}
                        </option>

                    @endforeach

                </select>

                <div class="mt-5">

                    <label
                        for="shelter_source_other"
                        class="text-sm font-semibold text-gray-700"
                    >
                        If Other, please specify
                    </label>

                    <input
                        type="text"
                        id="shelter_source_other"
                        name="shelter_source_other"
                        value="{{ old('shelter_source_other') }}"
                        @disabled(old('shelter_source') !== 'Other')
                        oninput="this.value = this.value.replace(/[^\p{L}\s.'-]/gu, '')"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition duration-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-400"
                    >

                </div>

            </div>

            {{-- ANIMAL PREFERENCES --}}
            <div class="border-t border-orange-100 pt-8">

                <div class="mb-6">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Your Preferences
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Animal Preferences
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        This information is automatically filled from your profile.
                        To change it, please update your animal preferences in My Profile.
                    </p>

                </div>

                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- ANIMAL PREFERENCE --}}
                    <div>

                        <label class="text-sm font-semibold text-gray-700">
                            Are you interested in a:
                        </label>

                        <input
                            type="text"
                            value="{{ $profile->animal_preference }}"
                            disabled
                            class="mt-2 w-full rounded-xl border border-orange-100 bg-orange-50/40 px-4 py-3 text-gray-600"
                        >

                    </div>

                    @if ($profile->animal_preference === 'Other')

                        <div>

                            <label class="text-sm font-semibold text-gray-700">
                                Other Animal
                            </label>

                            <input
                                type="text"
                                value="{{ $profile->animal_preference_other }}"
                                disabled
                                class="mt-2 w-full rounded-xl border border-orange-100 bg-orange-50/40 px-4 py-3 text-gray-600"
                            >

                        </div>

                    @endif

                    {{-- BREED --}}
                    <div>

                        <label class="text-sm font-semibold text-gray-700">
                            Breed / Mix
                        </label>

                        <input
                            type="text"
                            value="{{ $profile->preferred_breed ?: 'Not specified' }}"
                            disabled
                            class="mt-2 w-full rounded-xl border border-orange-100 bg-orange-50/40 px-4 py-3 text-gray-600"
                        >

                    </div>

                    {{-- PREFERRED SIZE --}}
                    <div>

                        <label class="text-sm font-semibold text-gray-700">
                            Preferred Size
                        </label>

                        <input
                            type="text"
                            value="{{ $profile->preferred_size ?: 'Not specified' }}"
                            disabled
                            class="mt-2 w-full rounded-xl border border-orange-100 bg-orange-50/40 px-4 py-3 text-gray-600"
                        >

                    </div>

                    {{-- PREFERRED AGE --}}
                    <div>

                        <label class="text-sm font-semibold text-gray-700">
                            Preferred Age
                        </label>

                        <input
                            type="text"
                            value="{{ $profile->preferred_age ?: 'Not specified' }}"
                            disabled
                            class="mt-2 w-full rounded-xl border border-orange-100 bg-orange-50/40 px-4 py-3 text-gray-600"
                        >

                    </div>

                    {{-- SELECTED PET --}}
                    <div>

                        <label class="text-sm font-semibold text-gray-700">
                            Name / Description of Animal
                        </label>

                        <div class="mt-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-3">

                            <p class="font-bold text-gray-900">
                                {{ $pet->name }}
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                {{ $pet->description }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ADOPTION AGREEMENT --}}
            <div class="border-t border-orange-100 pt-8">

                <div class="rounded-2xl border border-orange-100 bg-orange-50/60 p-5">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Important Information
                    </p>

                    <h2 class="mt-2 font-bold text-gray-900">
                        Adoption Agreement
                    </h2>

                    <p class="mt-2 text-sm leading-7 text-gray-600">
                        The Bayambang Animal Shelter adoption agreement
                        is completed separately on the day of adoption.
                        It is not part of this initial application.
                    </p>

                </div>

            </div>

            {{-- FORM ACTIONS --}}
            <div class="flex flex-col-reverse gap-3 border-t border-orange-100 pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('pets.show', $pet) }}"
                    class="rounded-full border border-gray-300 bg-white px-7 py-3 text-center font-semibold text-gray-700 transition duration-200 hover:border-orange-300 hover:bg-orange-50 hover:text-orange-600"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                >
                    Continue to Compatibility Assessment
                </button>

            </div>

        </form>

    </div>

</section>

@endsection