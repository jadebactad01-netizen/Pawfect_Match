
@extends('layouts.app')

@section('title', 'Login - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-12 sm:py-16">

    <div class="mx-auto max-w-md px-4 sm:px-6">

        {{-- LOGIN CARD --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            {{-- CARD HEADER --}}
            <div class="text-center">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Pawfect Match
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    Welcome Back
                </h1>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Log in to continue your Pawfect Match journey.
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

            {{-- LOGIN FORM --}}
            <form
                action="{{ url('/login') }}"
                method="POST"
                class="mt-8 space-y-5"
            >

                @csrf

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
                        autofocus
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
                        autocomplete="current-password"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

                {{-- REMEMBER ME --}}
                <label class="flex items-center gap-2 text-sm text-gray-600">

                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                    >

                    Remember me

                </label>

                {{-- LOGIN BUTTON --}}
                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Login
                </button>

            </form>

            {{-- REGISTER LINK --}}
            <p class="mt-7 border-t border-orange-100 pt-6 text-center text-sm text-gray-600">

                Don't have an account?

                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-orange-600 hover:text-orange-700"
                >
                    Create an account
                </a>

            </p>

        </div>

    </div>

</section>

@endsection
