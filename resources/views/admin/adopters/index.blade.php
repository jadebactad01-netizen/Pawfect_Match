@extends('layouts.app')

@section('title', 'Registered Adopters - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Registered Adopters
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                View registered adopter accounts, application history, and verification status.
            </p>

        </div>

        {{-- ADOPTERS LIST --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            {{-- SECTION HEADER --}}
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Adopter Records
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Adopter List
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Review registered adopters and their adoption activity.
                    </p>

                </div>

                <span class="rounded-full border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">
                    {{ $adopters->count() }}
                    {{ $adopters->count() === 1 ? 'Adopter' : 'Adopters' }}
                </span>

            </div>

            {{-- SEARCH BAR --}}
            <form
                action="{{ route('admin.adopters.index') }}"
                method="GET"
                class="mb-5 flex w-full flex-wrap items-center gap-3 sm:flex-nowrap"
            >

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search adopter name..."
                    aria-label="Search adopter name"
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
                        href="{{ route('admin.adopters.index') }}"
                        class="rounded-full border border-orange-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                    >
                        Clear
                    </a>

                @endif

            </form>

            {{-- ADOPTERS TABLE --}}
            <div class="overflow-x-auto rounded-xl border border-orange-100">

                <table class="min-w-full bg-white text-left text-sm">

                    <thead class="border-b border-orange-100 bg-orange-50/70 text-gray-700">

                        <tr>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Name
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Email
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Applications
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Account Status
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-right font-semibold">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-orange-100">

                        @forelse ($adopters as $adopter)

                            <tr class="transition hover:bg-orange-50/40">

                                {{-- NAME --}}
                                <td class="px-5 py-4 font-semibold text-gray-900">
                                    {{ $adopter->name }}
                                </td>

                                {{-- EMAIL --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $adopter->email }}
                                </td>

                                {{-- APPLICATION COUNT --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $adopter->adoption_applications_count }}
                                </td>

                                {{-- ACCOUNT STATUS --}}
                                <td class="px-5 py-4">

                                    <span
                                        class="inline-block whitespace-nowrap rounded-full border px-3 py-1 text-xs font-semibold
                                        @if ($adopter->approval_status === 'Approved')
                                            border-green-200 bg-green-50 text-green-700
                                        @elseif ($adopter->approval_status === 'Rejected')
                                            border-red-200 bg-red-50 text-red-700
                                        @else
                                            border-amber-200 bg-amber-50 text-amber-700
                                        @endif"
                                    >
                                        {{ $adopter->approval_status ?? 'Pending' }}
                                    </span>

                                </td>

                                {{-- ACTION --}}
                                <td class="px-5 py-4 text-right">

                                    @if ($adopter->approval_status === 'Approved')

                                        <a
                                            href="{{ route('admin.adopters.show', $adopter) }}"
                                            class="inline-flex items-center justify-center whitespace-nowrap rounded-full border border-orange-300 bg-white px-4 py-2 text-xs font-semibold text-orange-600 transition hover:bg-orange-50"
                                        >
                                            View Details
                                        </a>

                                    @else

                                        <a
                                            href="{{ route('admin.account-approvals.index') }}"
                                            class="inline-flex items-center justify-center whitespace-nowrap rounded-full border border-orange-300 bg-white px-4 py-2 text-xs font-semibold text-orange-600 transition hover:bg-orange-50"
                                        >
                                            Review Account
                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <p class="font-semibold text-gray-700">
                                        No registered adopters found
                                    </p>

                                    <p class="mt-2 text-sm text-gray-500">

                                        @if ($search)
                                            No adopters match your search. Try another name.
                                        @else
                                            There are no registered adopters yet.
                                        @endif

                                    </p>

                                    @if ($search)

                                        <a
                                            href="{{ route('admin.adopters.index') }}"
                                            class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
                                        >
                                            Clear Search
                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

@endsection