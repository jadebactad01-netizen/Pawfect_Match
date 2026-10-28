@extends('layouts.app')

@section('title', 'Manage Pets - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col gap-5 rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Shelter Management
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    Manage Pets
                </h1>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Add, update, and manage pets registered in the Pawfect Match system.
                </p>

            </div>

            <a
                href="{{ route('admin.pets.add') }}"
                class="inline-flex shrink-0 items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
            >
                + Add Pet
            </a>

        </div>

        {{-- PET MANAGEMENT LIST --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            {{-- SECTION HEADER --}}
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Pet Records
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Registered Pets
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        View and manage all non-adopted pets in the shelter.
                    </p>

                </div>

                <span class="rounded-full border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">
                    {{ $pets->count() }} {{ $pets->count() === 1 ? 'Pet' : 'Pets' }}
                </span>

            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))

                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif

            {{-- SEARCH BAR --}}
            <form
                action="{{ route('admin.pets.manage') }}"
                method="GET"
                class="mb-5 flex w-full flex-wrap items-center gap-3 sm:flex-nowrap"
            >

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search pet name..."
                    aria-label="Search pet name"
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
                        href="{{ route('admin.pets.manage') }}"
                        class="rounded-full border border-orange-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                    >
                        Clear
                    </a>

                @endif

            </form>

            {{-- PETS TABLE --}}
            <div class="overflow-x-auto rounded-xl border border-orange-100">

                <table class="min-w-full bg-white text-left text-sm">

                    <thead class="border-b border-orange-100 bg-orange-50/70 text-gray-700">

                        <tr>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Name
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Type
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Sex
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Age
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Status
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-right font-semibold">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-orange-100">

                        @forelse ($pets as $pet)

                            <tr class="transition hover:bg-orange-50/40">

                                {{-- PET NAME --}}
                                <td class="px-5 py-4 font-semibold text-gray-900">
                                    {{ $pet->name }}
                                </td>

                                {{-- TYPE --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $pet->type }}
                                </td>

                                {{-- SEX --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $pet->sex }}
                                </td>

                                {{-- AGE --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $pet->age }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-5 py-4">

                                    <span class="inline-block whitespace-nowrap rounded-full border px-3 py-1 text-xs font-semibold
                                        {{
                                            $pet->status === 'Available'
                                                ? 'border-green-200 bg-green-50 text-green-700'
                                                : 'border-red-200 bg-red-50 text-red-700'
                                        }}"
                                    >
                                        {{ $pet->status }}
                                    </span>

                                </td>

                                {{-- ACTIONS --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('admin.pets.edit', $pet) }}"
                                            class="rounded-full border border-orange-300 bg-white px-4 py-2 text-xs font-semibold text-orange-600 transition hover:bg-orange-50"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.pets.destroy', $pet) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Are you sure you want to delete this pet?')"
                                                class="rounded-full border border-red-200 bg-white px-4 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-12 text-center">

                                    <p class="font-semibold text-gray-700">
                                        No pets found
                                    </p>

                                    <p class="mt-2 text-sm text-gray-500">
                                        @if ($search)
                                            No pets match your search. Try another pet name.
                                        @else
                                            There are no pets registered in this list yet.
                                        @endif
                                    </p>

                                    @if ($search)

                                        <a
                                            href="{{ route('admin.pets.manage') }}"
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