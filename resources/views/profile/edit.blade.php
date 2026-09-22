@extends('layouts.app')

@section('title', 'My Profile - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50 px-4 py-10 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-3xl">

        {{-- Page Heading --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                My Adopter Profile
            </h1>

            <p class="mt-2 text-gray-600">
                Tell us about your home and lifestyle to help us find
                pets that may be compatible with you.
            </p>
        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200
                        bg-red-50 px-4 py-3 text-red-700">

                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- Profile Form --}}
        <form
            action="{{ route('profile.update') }}"
            method="POST"
            class="rounded-2xl bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf
            @method('PUT')


            {{-- Contact Information --}}
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Contact Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Basic information the shelter may use to contact you.
                </p>
            </div>


            <div class="mt-6 grid gap-6 sm:grid-cols-2">

                {{-- Phone Number --}}
                <div>
                    <label
                        for="phone_number"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Phone Number
                    </label>

                    <input
                        type="text"
                        id="phone_number"
                        name="phone_number"
                        value="{{ old('phone_number', $profile?->phone_number) }}"
                        placeholder="Enter your phone number"
                        class="w-full rounded-lg border border-gray-300
                               px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                </div>


                {{-- Address --}}
                <div>
                    <label
                        for="address"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Address
                    </label>

                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address', $profile?->address) }}"
                        placeholder="Enter your address"
                        class="w-full rounded-lg border border-gray-300
                               px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                </div>

            </div>


            {{-- Compatibility Information --}}
            <div class="mt-10 border-t border-gray-200 pt-8">

                <h2 class="text-xl font-bold text-gray-900">
                    Lifestyle & Household
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    These answers will later help Pawfect Match calculate
                    pet compatibility.
                </p>

            </div>


            <div class="mt-6 grid gap-6 sm:grid-cols-2">

                {{-- Living Environment --}}
                <div>
                    <label
                        for="living_environment"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Living Environment
                    </label>

                    <select
                        id="living_environment"
                        name="living_environment"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                        <option value="">Select an option</option>

                        <option value="House"
                            @selected(old('living_environment', $profile?->living_environment) === 'House')>
                            House
                        </option>

                        <option value="Apartment"
                            @selected(old('living_environment', $profile?->living_environment) === 'Apartment')>
                            Apartment
                        </option>

                        <option value="Other"
                            @selected(old('living_environment', $profile?->living_environment) === 'Other')>
                            Other
                        </option>
                    </select>
                </div>


                {{-- Household --}}
                <div>
                    <label
                        for="household"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Household
                    </label>

                    <select
                        id="household"
                        name="household"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                        <option value="">Select an option</option>

                        <option value="Living alone"
                            @selected(old('household', $profile?->household) === 'Living alone')>
                            Living alone
                        </option>

                        <option value="Adults only"
                            @selected(old('household', $profile?->household) === 'Adults only')>
                            Adults only
                        </option>

                        <option value="Family with children"
                            @selected(old('household', $profile?->household) === 'Family with children')>
                            Family with children
                        </option>
                    </select>
                </div>


                {{-- Available Time --}}
                <div>
                    <label
                        for="available_time"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Available Time for a Pet
                    </label>

                    <select
                        id="available_time"
                        name="available_time"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                        <option value="">Select an option</option>

                        <option value="Low"
                            @selected(old('available_time', $profile?->available_time) === 'Low')>
                            Low
                        </option>

                        <option value="Moderate"
                            @selected(old('available_time', $profile?->available_time) === 'Moderate')>
                            Moderate
                        </option>

                        <option value="High"
                            @selected(old('available_time', $profile?->available_time) === 'High')>
                            High
                        </option>
                    </select>
                </div>


                {{-- Pet Care Experience --}}
                <div>
                    <label
                        for="pet_care_experience"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Pet Care Experience
                    </label>

                    <select
                        id="pet_care_experience"
                        name="pet_care_experience"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                        <option value="">Select an option</option>

                        <option value="None"
                            @selected(old('pet_care_experience', $profile?->pet_care_experience) === 'None')>
                            No experience
                        </option>

                        <option value="Some"
                            @selected(old('pet_care_experience', $profile?->pet_care_experience) === 'Some')>
                            Some experience
                        </option>

                        <option value="Experienced"
                            @selected(old('pet_care_experience', $profile?->pet_care_experience) === 'Experienced')>
                            Experienced
                        </option>
                    </select>
                </div>


                {{-- Activity Level --}}
                <div>
                    <label
                        for="activity_level"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Activity Level
                    </label>

                    <select
                        id="activity_level"
                        name="activity_level"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                        <option value="">Select an option</option>

                        <option value="Low"
                            @selected(old('activity_level', $profile?->activity_level) === 'Low')>
                            Low
                        </option>

                        <option value="Moderate"
                            @selected(old('activity_level', $profile?->activity_level) === 'Moderate')>
                            Moderate
                        </option>

                        <option value="High"
                            @selected(old('activity_level', $profile?->activity_level) === 'High')>
                            High
                        </option>
                    </select>
                </div>


                {{-- Care Ability --}}
                <div>
                    <label
                        for="care_ability"
                        class="mb-2 block font-medium text-gray-700"
                    >
                        Ability to Care for a Pet
                    </label>

                    <select
                        id="care_ability"
                        name="care_ability"
                        required
                        class="w-full rounded-lg border border-gray-300
                               bg-white px-4 py-3 outline-none
                               focus:border-orange-500"
                    >
                        <option value="">Select an option</option>

                        <option value="Limited"
                            @selected(old('care_ability', $profile?->care_ability) === 'Limited')>
                            Limited
                        </option>

                        <option value="Moderate"
                            @selected(old('care_ability', $profile?->care_ability) === 'Moderate')>
                            Moderate
                        </option>

                        <option value="High"
                            @selected(old('care_ability', $profile?->care_ability) === 'High')>
                            High
                        </option>
                    </select>
                </div>

            </div>


            {{-- Save Button --}}
            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500
                           px-6 py-3 font-semibold text-white
                           hover:bg-orange-600 sm:w-auto"
                >
                    Save Profile
                </button>

            </div>

        </form>

    </div>

</section>

@endsection