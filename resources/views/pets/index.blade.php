@extends('layouts.app')

@section('title', 'Available Pets - Pawfect Match')

@section('content')

{{-- PAGE HEADER --}}
<section class="relative overflow-hidden border-b border-orange-100 bg-orange-50 py-16">

    <div class="relative mx-auto max-w-7xl px-6 text-center">

        <p class="text-sm font-semibold uppercase tracking-wider text-orange-500">
            Find a Companion
        </p>

        <h1 class="mt-2 text-4xl font-bold text-gray-900 sm:text-5xl">
            Available Pets
        </h1>

        <div class="mx-auto mt-4 h-1 w-14 rounded-full bg-orange-400"></div>

        <p class="mx-auto mt-5 max-w-2xl leading-7 text-gray-600">
            Meet the pets currently looking for their forever homes.
            Browse their profiles and find a companion that may be
            right for you.
        </p>

    </div>

</section>

{{-- PET FILTERS --}}
<section class="border-b border-orange-100 bg-white">

    <div class="mx-auto max-w-7xl px-6 py-6">

        {{-- MAIN FILTER ROW --}}
        <div class="flex flex-wrap items-center justify-between gap-4">

            <p class="text-sm text-gray-600">
                Showing
                <span class="font-bold text-orange-600">
                    {{ $pets->total() }}
                </span>
                available pets
            </p>

            <div class="flex flex-wrap gap-2">

                {{-- ALL --}}
                <a
                    href="{{ route('pets.index') }}"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition duration-200
                        {{ !$type
                            ? 'bg-orange-500 text-white shadow-sm'
                            : 'border border-orange-200 bg-white text-gray-600 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-600' }}"
                >
                    All
                </a>

                {{-- DOGS --}}
                <a
                    href="{{ route('pets.index', ['type' => 'Dog']) }}"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition duration-200
                        {{ $type === 'Dog'
                            ? 'bg-orange-500 text-white shadow-sm'
                            : 'border border-orange-200 bg-white text-gray-600 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-600' }}"
                >
                    Dogs
                </a>

                {{-- CATS --}}
                <a
                    href="{{ route('pets.index', ['type' => 'Cat']) }}"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition duration-200
                        {{ $type === 'Cat'
                            ? 'bg-orange-500 text-white shadow-sm'
                            : 'border border-orange-200 bg-white text-gray-600 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-600' }}"
                >
                    Cats
                </a>

            </div>

        </div>

        {{-- ADDITIONAL FILTERS FOR DOGS OR CATS --}}
        @if ($type === 'Dog' || $type === 'Cat')

            <div class="mt-6 border-t border-orange-100 pt-6">

                <p class="mb-4 text-sm font-semibold text-gray-700">
                    Filter {{ $type === 'Dog' ? 'Dogs' : 'Cats' }}
                    by Characteristics
                </p>

                <form
                    action="{{ route('pets.index') }}"
                    method="GET"
                    class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 lg:grid-cols-3"
                >

                    {{-- KEEP SELECTED PET TYPE --}}
                    <input
                        type="hidden"
                        name="type"
                        value="{{ $type }}"
                    >

                    {{-- BREED --}}
                    <div>

                        <label
                            for="breed"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Breed
                        </label>

                        <select
                            id="breed"
                            name="breed"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            <option value="">All Breeds</option>

                            @foreach ($breeds as $option)

                                <option
                                    value="{{ $option }}"
                                    @selected($breed === $option)
                                >
                                    {{ $option }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- COLOR --}}
                    <div>

                        <label
                            for="color"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Color
                        </label>

                        <select
                            id="color"
                            name="color"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            <option value="">All Colors</option>

                            @foreach ($colors as $option)

                                <option
                                    value="{{ $option }}"
                                    @selected($color === $option)
                                >
                                    {{ $option }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- SIZE --}}
                    <div>

                        <label
                            for="size"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Size
                        </label>

                        <select
                            id="size"
                            name="size"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >

                            <option value="">All Sizes</option>

                            @foreach ($sizes as $option)

                                <option
                                    value="{{ $option }}"
                                    @selected($size === $option)
                                >
                                    {{ $option }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- FILTER BUTTONS --}}
                    <div class="flex flex-wrap items-center gap-3 sm:col-span-2 lg:col-span-3">

                        <button
                            type="submit"
                            class="rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600"
                        >
                            Apply Filters
                        </button>

                        <a
                            href="{{ route('pets.index', ['type' => $type]) }}"
                            class="rounded-full border border-orange-200 bg-white px-6 py-3 text-sm font-semibold text-gray-600 transition duration-200 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-600"
                        >
                            Clear Filters
                        </a>

                    </div>

                </form>

            </div>

        @endif

    </div>

</section>

{{-- PET LIST --}}
<section class="bg-orange-50/40 py-16">

    <div class="mx-auto max-w-7xl px-6">

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($pets as $pet)

                {{-- PET CARD --}}
                <div class="group overflow-hidden rounded-2xl border border-orange-100 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg">

                    {{-- PHOTO --}}
                    <div class="h-60 overflow-hidden bg-orange-100">

                        @if ($pet->photo)

                            <img
                                src="{{ asset('storage/' . $pet->photo) }}"
                                alt="{{ $pet->name }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center bg-orange-50 text-sm text-gray-500">
                                No photo available
                            </div>

                        @endif

                    </div>

                    {{-- PET INFORMATION --}}
                    <div class="p-6">

                        <div class="flex items-center justify-between gap-3">

                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $pet->name }}
                            </h2>

                            <span class="rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                {{ $pet->status }}
                            </span>

                        </div>

                        {{-- FORMAT AGE --}}
                        @php
                            $petAge = trim($pet->age);

                            $formattedAge = preg_replace_callback(
                                '/^(\d+)\s+(year|month)s?$/i',
                                function ($matches) {
                                    return $matches[1] . ' ' .
                                        strtolower($matches[2]) .
                                        ($matches[1] == 1 ? '' : 's') .
                                        ' old';
                                },
                                $petAge
                            );
                        @endphp

                        <p class="mt-2 text-sm text-gray-500">
                            {{ $pet->type }}
                            • {{ $pet->sex }}
                            • {{ $formattedAge }}
                        </p>

                        <p class="mt-4 leading-7 text-gray-600">
                            {{ $pet->description }}
                        </p>

                        <div class="mt-6 border-t border-orange-100 pt-5">

                            <a
                                href="{{ route('pets.show', $pet) }}"
                                class="inline-block rounded-full bg-orange-500 px-6 py-2.5 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                            >
                                View Profile
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                {{-- EMPTY STATE --}}
                <div class="rounded-2xl border border-orange-100 bg-white px-6 py-12 text-center shadow-sm sm:col-span-2 lg:col-span-3">

                    <div class="mx-auto mb-5 h-1 w-14 rounded-full bg-orange-400"></div>

                    <h2 class="text-2xl font-bold text-gray-900">
                        No Pets Found
                    </h2>

                    <p class="mt-3 text-gray-600">
                        There are currently no available pets
                        matching this filter.
                    </p>

                    <a
                        href="{{ route('pets.index') }}"
                        class="mt-6 inline-block rounded-full bg-orange-500 px-6 py-3 font-semibold transition duration-200 text-white hover:bg-orange-600 hover:shadow-md"
                    >
                        View All Pets
                    </a>

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        <x-pagination :paginator="$pets" />

    </div>

</section>

@endsection
