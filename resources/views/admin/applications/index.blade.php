@extends('layouts.app')

@section('title', 'Adoption Applications - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Adoption Applications
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Review pending adoption applications submitted by adopters.
            </p>

        </div>

        {{-- APPLICATION LIST --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            {{-- SECTION HEADER --}}
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Application Management
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Pending Applications
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Applications with completed compatibility assessments waiting for review.
                    </p>

                </div>

                <span class="rounded-full border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                    {{ $applications->count() }}
                    {{ $applications->count() === 1 ? 'Application' : 'Applications' }}
                </span>

            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))

                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif

            {{-- ERROR MESSAGE --}}
            @if (session('error'))

                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>

            @endif

            {{-- SEARCH BAR --}}
            <form
                action="{{ route('admin.applications.index') }}"
                method="GET"
                class="mb-5 flex w-full flex-wrap items-center gap-3 sm:flex-nowrap"
            >

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search pet or adopter name..."
                    aria-label="Search pet or adopter name"
                    class="min-w-0 flex-1 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                >

                <button
                    type="submit"
                    class="rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Search
                </button>

                @if ($search)

                    <a
                        href="{{ route('admin.applications.index') }}"
                        class="rounded-full border border-orange-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                    >
                        Clear
                    </a>

                @endif

            </form>

            {{-- APPLICATIONS --}}
            @forelse ($applications as $application)

                <div class="mb-3 rounded-xl border border-orange-100 bg-orange-50/30 p-4 last:mb-0 sm:p-5">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        {{-- APPLICATION DETAILS --}}
                        <div class="grid min-w-0 flex-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Application
                                </p>

                                <p class="mt-1 text-sm font-bold text-gray-900">
                                    #{{ $application->id }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Applicant
                                </p>

                                <p class="mt-1 break-words text-sm font-semibold text-gray-900">
                                    {{ $application->user?->name ?? 'Unavailable' }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Pet
                                </p>

                                <p class="mt-1 break-words text-sm font-semibold text-gray-900">
                                    {{ $application->pet?->name ?? 'Unavailable' }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Submitted
                                </p>

                                <p class="mt-1 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $application->created_at->format('M d, Y') }}
                                </p>

                            </div>

                        </div>

                        {{-- STATUS AND ACTION --}}
                        <div class="flex shrink-0 flex-wrap items-center gap-3">

                            <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700">
                                {{ $application->status }}
                            </span>

                            <a
                                href="{{ route('admin.applications.show', $application) }}"
                                class="inline-flex items-center justify-center rounded-full bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                            >
                                Review Application
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                {{-- EMPTY STATE --}}
                <div class="rounded-xl border border-orange-100 bg-orange-50/40 px-6 py-10 text-center">

                    <p class="text-lg font-bold text-gray-900">
                        No Pending Applications
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        @if ($search)
                            No pending applications match your search. Try another pet or adopter name.
                        @else
                            There are no pending applications ready for review.
                        @endif
                    </p>

                    @if ($search)

                        <a
                            href="{{ route('admin.applications.index') }}"
                            class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
                        >
                            Clear Search
                        </a>

                    @endif

                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection