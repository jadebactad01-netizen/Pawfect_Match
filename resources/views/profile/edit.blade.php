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
                Keep your contact information up to date for your
                adoption applications.
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