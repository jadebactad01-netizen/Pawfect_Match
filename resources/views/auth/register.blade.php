
@extends('layouts.app')

@section('title', 'Register - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-12 sm:py-16">

    <div class="mx-auto max-w-lg px-4 sm:px-6">

        {{-- REGISTRATION CARD --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            {{-- CARD HEADER --}}
            <div class="text-center">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Pawfect Match
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    Create Your Account
                </h1>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Join Pawfect Match and find a pet that fits your lifestyle.
                </p>

                {{-- ACCOUNT APPROVAL NOTICE --}}
                <p class="mt-5 rounded-xl border border-orange-200 bg-orange-50 p-4 text-sm leading-6 text-orange-800">
                    All new adopter accounts require one valid ID
                    and shelter administrator approval.
                </p>

            </div>

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())

                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

                    <ul class="list-disc space-y-1 pl-5">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- REGISTRATION FORM --}}
            <form
                action="{{ url('/register') }}"
                method="POST"
                enctype="multipart/form-data"
                class="mt-7 space-y-5"
            >

                @csrf

                {{-- FULL NAME --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

                {{-- EMAIL --}}
                <div>

                    <label
                        for="email"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

                {{-- PASSWORD --}}
                <div>

                    <label
                        for="password"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

                {{-- CONFIRM PASSWORD --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

                {{-- VALID ID UPLOAD --}}
                <div class="border-t border-orange-100 pt-5">

                    <label
                        for="valid_id"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Upload One Valid ID
                        <span class="text-red-500">*</span>
                    </label>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Upload a clear photo of a government-issued or
                        other shelter-accepted identification document.
                        JPG, PNG, or WebP only. Maximum 5 MB.
                    </p>

                    <input
                        type="file"
                        id="valid_id"
                        name="valid_id"
                        accept="image/jpeg,image/png,image/webp"
                        required
                        class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-3 py-3 text-sm text-gray-700 outline-none transition file:mr-3 file:rounded-lg file:border-0 file:bg-orange-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-orange-700 hover:file:bg-orange-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                    <p class="mt-3 text-xs leading-5 text-gray-500">
                        Your ID will be reviewed by authorized shelter staff
                        for account verification. It will not appear on your
                        public adopter profile.
                    </p>

                </div>

                {{-- SUBMIT REGISTRATION --}}
                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Submit Registration for Approval
                </button>

            </form>

            {{-- LOGIN LINK --}}
            <p class="mt-7 border-t border-orange-100 pt-6 text-center text-sm text-gray-600">

                Already have an account?

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-orange-600 hover:text-orange-700"
                >
                    Login
                </a>

            </p>

        </div>

    </div>

</section>

@endsection
