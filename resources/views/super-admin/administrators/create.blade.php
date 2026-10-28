
@extends('layouts.app')

@section('title', 'Add Administrator')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Super Administration
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Add Administrator
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Create an account for a shelter administrator.
            </p>

            <a
                href="{{ route('super-admin.administrators.index') }}"
                class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
            >
                ← Back to Administrators
            </a>

        </div>

        {{-- ADMINISTRATOR FORM --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <form
                action="{{ route('super-admin.administrators.store') }}"
                method="POST"
            >

                @csrf

                {{-- NAME AND EMAIL --}}
                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label
                            for="name"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label
                            for="email"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- PASSWORD AND CONFIRM PASSWORD --}}
                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    <div>

                        <label
                            for="password"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label
                            for="password_confirmation"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Confirm Password
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                    </div>

                </div>

                {{-- FORM ACTIONS --}}
                <div class="mt-7 flex flex-wrap items-center justify-end gap-3 border-t border-orange-100 pt-5">

                    <a
                        href="{{ route('super-admin.administrators.index') }}"
                        class="rounded-full border border-orange-200 bg-white px-6 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                    >
                        Create Administrator
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection
