
@extends('layouts.app')

@section('title', 'Adoption Records')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Adoption Records
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                View adoption applications that have already been evaluated by the shelter.
            </p>

        </div>

        {{-- RECORDS LIST --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            {{-- SECTION HEADER --}}
            <div class="mb-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Adoption Management
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Evaluated Applications
                </h2>

            </div>

            {{-- STATUS FILTERS --}}
            <div class="mb-5 flex flex-wrap gap-3">

                <a
                    href="{{ route('admin.adoption-records.index', $search ? ['search' => $search] : []) }}"
                    class="rounded-full border px-5 py-2.5 text-sm font-semibold transition
                        {{ ! in_array($status, ['Approved', 'Rejected'])
                            ? 'border-orange-500 bg-orange-500 text-white'
                            : 'border-orange-200 bg-white text-gray-700 hover:bg-orange-50' }}"
                >
                    All Records
                </a>

                <a
                    href="{{ route('admin.adoption-records.index', array_filter(['status' => 'Approved', 'search' => $search])) }}"
                    class="rounded-full border px-5 py-2.5 text-sm font-semibold transition
                        {{ $status === 'Approved'
                            ? 'border-green-600 bg-green-600 text-white'
                            : 'border-green-200 bg-white text-gray-700 hover:bg-green-50' }}"
                >
                    Approved
                </a>

                <a
                    href="{{ route('admin.adoption-records.index', array_filter(['status' => 'Rejected', 'search' => $search])) }}"
                    class="rounded-full border px-5 py-2.5 text-sm font-semibold transition
                        {{ $status === 'Rejected'
                            ? 'border-red-600 bg-red-600 text-white'
                            : 'border-red-200 bg-white text-gray-700 hover:bg-red-50' }}"
                >
                    Rejected
                </a>

            </div>

            {{-- SEARCH BAR --}}
            <form
                action="{{ route('admin.adoption-records.index') }}"
                method="GET"
                class="mb-5 flex w-full flex-wrap items-center gap-3 sm:flex-nowrap"
            >

                @if ($status)
                    <input
                        type="hidden"
                        name="status"
                        value="{{ $status }}"
                    >
                @endif

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search pet or adopter name..."
                    aria-label="Search pet or adopter name"
                    class="min-w-0 flex-1 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                >

                <button
                    type="submit"
                    class="rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Search
                </button>

                @if ($search)
                    <a
                        href="{{ route('admin.adoption-records.index', in_array($status, ['Approved', 'Rejected']) ? ['status' => $status] : []) }}"
                        class="rounded-full border border-orange-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                    >
                        Clear
                    </a>
                @endif

            </form>

            {{-- ADOPTION RECORDS --}}
            @forelse ($records as $record)

                <div class="mb-3 rounded-xl border border-orange-100 bg-orange-50/30 p-4 last:mb-0 sm:p-5">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        {{-- RECORD DETAILS --}}
                        <div class="grid min-w-0 flex-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Record
                                </p>

                                <p class="mt-1 text-sm font-bold text-gray-900">
                                    #{{ $record->id }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Applicant
                                </p>

                                <p class="mt-1 break-words text-sm font-semibold text-gray-900">
                                    {{ $record->user->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Pet
                                </p>

                                <p class="mt-1 break-words text-sm font-semibold text-gray-900">
                                    {{ $record->pet->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Submitted
                                </p>

                                <p class="mt-1 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $record->created_at->format('M d, Y') }}
                                </p>
                            </div>

                        </div>

                        {{-- STATUS AND ACTION --}}
                        <div class="flex shrink-0 flex-wrap items-center gap-3">

                            <span class="rounded-full border px-3 py-2 text-xs font-semibold
                                {{ $record->status === 'Approved'
                                    ? 'border-green-200 bg-green-50 text-green-700'
                                    : 'border-red-200 bg-red-50 text-red-700' }}"
                            >
                                {{ $record->status }}
                            </span>

                            <a
                                href="{{ route('admin.adoption-records.show', $record) }}"
                                class="inline-flex items-center justify-center rounded-full bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                            >
                                View Record
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="rounded-xl border border-orange-100 bg-orange-50/40 px-6 py-10 text-center">

                    <h2 class="text-lg font-bold text-gray-900">
                        No Adoption Records
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        No matching adoption records found.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection
