
@extends('layouts.app')

@section('title', 'Manage Administrators')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4 rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Super Administration
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    Administrators
                </h1>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Manage shelter administrator accounts.
                </p>

            </div>

            <a
                href="{{ route('super-admin.administrators.create') }}"
                class="inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
            >
                Add Administrator
            </a>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>

        @endif

        {{-- ADMINISTRATORS LIST --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Account Management
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Administrator List
                </h2>

            </div>

            <div class="overflow-x-auto rounded-xl border border-orange-100">

                <table class="min-w-full text-left text-sm">

                    <thead class="border-b border-orange-100 bg-orange-50/70 text-gray-700">

                        <tr>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Name
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Email
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Created
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-right font-semibold">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-orange-100">

                        @forelse ($administrators as $administrator)

                            <tr class="transition hover:bg-orange-50/40">

                                {{-- ADMINISTRATOR NAME --}}
                                <td class="px-5 py-4 font-semibold text-gray-900">
                                    {{ $administrator->name }}
                                </td>

                                {{-- EMAIL --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $administrator->email }}
                                </td>

                                {{-- DATE CREATED --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $administrator->created_at->format('M d, Y') }}
                                </td>

                                {{-- ACTIONS --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('super-admin.administrators.edit', $administrator) }}"
                                            class="inline-flex items-center justify-center rounded-full border border-orange-300 bg-white px-4 py-2 text-xs font-semibold text-orange-600 transition hover:bg-orange-50"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('super-admin.administrators.destroy', $administrator) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this administrator account?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-full border border-red-200 bg-white px-4 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-10 text-center">

                                    <p class="text-sm text-gray-500">
                                        No administrator accounts found.
                                    </p>

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
