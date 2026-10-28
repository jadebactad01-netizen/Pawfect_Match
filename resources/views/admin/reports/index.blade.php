
@extends('layouts.app')

@section('title', 'Printable Reports - Pawfect Match')

@section('content')

@php
    $titles = [
        'pets' => 'Pet Inventory Report',
        'adopters' => 'Registered Adopters Report',
        'applications' => 'Adoption Applications Report',
        'records' => 'Adoption Records Report',
    ];

    $reportTitle = $titles[$type];
@endphp

<style>
    @media print {
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            background: white !important;
            color: black !important;
        }

        header, footer, nav, #mobile-menu,
        .no-print {
            display: none !important;
        }

        .report-page {
            background: white !important;
            padding: 0 !important;
            min-height: auto !important;
        }

        .report-container {
            max-width: none !important;
            padding: 0 !important;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #999 !important;
            padding: 7px !important;
            color: black !important;
        }

        .report-table thead {
            background: #eee !important;
        }

        .report-table tr {
            break-inside: avoid;
        }

        .report-table thead {
            display: table-header-group;
        }

        .report-heading {
            display: block !important;
        }

        .report-data {
            overflow: visible !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
        }
    }
</style>

<section class="report-page min-h-screen bg-orange-50/40 py-10">

    <div class="report-container mx-auto max-w-7xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="no-print rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Printable Reports
            </h1>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Generate and print shelter records or save them as PDF.
            </p>

            <a
                href="{{ auth()->user()->role === 'super_admin'
                    ? route('super-admin.dashboard')
                    : route('admin.dashboard') }}"
                class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700"
            >
                ← Back to Dashboard
            </a>

        </div>

        {{-- REPORT FILTERS --}}
        <form
            action="{{ route('admin.reports.index') }}"
            method="GET"
            class="no-print rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6"
        >

            <div class="mb-5 border-b border-orange-100 pb-4">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Report Management
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Report Filters
                </h2>

            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- REPORT TYPE --}}
                <div>

                    <label
                        for="type"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Report Type
                    </label>

                    <select
                        id="type"
                        name="type"
                        onchange="updateReportStatus()"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        @foreach ($titles as $key => $title)
                            <option
                                value="{{ $key }}"
                                @selected($type === $key)
                            >
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>

                </div>

                {{-- STATUS --}}
                <div>

                    <label
                        for="status"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        <option value="">All statuses</option>

                        @foreach (['Available', 'Unavailable', 'Adopted', 'Pending', 'Approved', 'Rejected'] as $option)
                            <option
                                value="{{ $option }}"
                                @selected($status === $option)
                            >
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>

                </div>

                {{-- FROM DATE --}}
                <div>

                    <label
                        for="date_from"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        From Date
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ $dateFrom }}"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

                {{-- TO DATE --}}
                <div>

                    <label
                        for="date_to"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        To Date
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ $dateTo }}"
                        class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                </div>

            </div>

            {{-- EXISTING REPORT ACTIONS --}}
            <div class="mt-5 flex flex-wrap items-center gap-3">

                <button
                    type="submit"
                    class="rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Generate Report
                </button>

                <a
                    href="{{ route('admin.reports.index') }}"
                    class="rounded-full border border-orange-200 bg-white px-6 py-3 text-sm font-semibold text-gray-600 transition hover:bg-orange-50"
                >
                    Clear Filters
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="rounded-full bg-gray-800 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-900"
                >
                    Print / Save as PDF
                </button>

            </div>

        </form>

        {{-- REPORT CONTENT --}}
        <div class="report-data overflow-x-auto rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            {{-- PRINTED REPORT HEADER --}}
            <div class="report-heading mb-6 text-center">

                <p class="text-sm font-semibold uppercase tracking-wide text-gray-600">
                    Bayambang Animal Shelter
                </p>

                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                    {{ $reportTitle }}
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    Pawfect Match — Pet Adoption Management System
                </p>

                <div class="mt-4 text-sm text-gray-600">

                    <p>
                        Generated: {{ now()->format('F d, Y h:i A') }}
                    </p>

                    @if ($dateFrom || $dateTo)

                        <p class="mt-1">
                            Registration / Submission Period:
                            {{ $dateFrom ?: 'Beginning' }}
                            to
                            {{ $dateTo ?: 'Present' }}
                        </p>

                    @endif

                    @if ($status)

                        <p class="mt-1">
                            Status Filter: {{ $status }}
                        </p>

                    @endif

                    <p class="mt-2 font-semibold text-orange-600">
                        Total Records: {{ $rows->count() }}
                    </p>

                </div>

            </div>

            {{-- REPORT TABLE --}}
            <div class="overflow-x-auto rounded-xl border border-orange-100 print:overflow-visible">

                <table class="report-table min-w-full border-collapse text-left text-sm">

                    <thead class="bg-orange-50/70 text-gray-700">

                        @if ($type === 'pets')

                            <tr>
                                <th class="px-4 py-3">Pet Name</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Sex</th>
                                <th class="px-4 py-3">Age</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Origin</th>
                                <th class="px-4 py-3">Intake Date</th>
                                <th class="px-4 py-3">Vaccination</th>
                                <th class="px-4 py-3">Vaccination Date</th>
                            </tr>

                        @elseif ($type === 'adopters')

                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Registered On</th>
                                <th class="px-4 py-3">Applications</th>
                            </tr>

                        @else

                            <tr>
                                <th class="px-4 py-3">Application #</th>
                                <th class="px-4 py-3">Adopter</th>
                                <th class="px-4 py-3">Pet</th>
                                <th class="px-4 py-3">Submitted</th>
                                <th class="px-4 py-3">Compatibility</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>

                        @endif

                    </thead>

                    <tbody class="divide-y divide-orange-100">

                        @forelse ($rows as $row)

                            @if ($type === 'pets')

                                <tr class="hover:bg-orange-50/40">

                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        {{ $row->name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->type }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->sex }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->age }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->status }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->intake_type ?: 'Not recorded' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->intake_date?->format('M d, Y') ?? 'Not recorded' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->vaccination_type ?: 'Not recorded' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->vaccination_date?->format('M d, Y') ?? 'Not recorded' }}
                                    </td>

                                </tr>

                            @elseif ($type === 'adopters')

                                <tr class="hover:bg-orange-50/40">

                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        {{ $row->name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->email }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->adoption_applications_count }}
                                    </td>

                                </tr>

                            @else

                                <tr class="hover:bg-orange-50/40">

                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        #{{ $row->id }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->user?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->pet?->name ?? 'Unavailable' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->compatibilityAssessment?->total_score !== null
                                            ? $row->compatibilityAssessment->total_score . '%'
                                            : 'Not completed' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $row->status }}
                                    </td>

                                </tr>

                            @endif

                        @empty

                            <tr>
                                <td
                                    colspan="{{ $type === 'pets' ? 9 : ($type === 'adopters' ? 4 : 6) }}"
                                    class="px-6 py-10 text-center text-gray-500"
                                >
                                    No matching records found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PRINT FOOTER --}}
        <div class="mt-10 hidden justify-between border-t border-gray-300 pt-4 text-xs text-gray-600 print:flex">
            <span>Bayambang Animal Shelter — Pawfect Match</span>
            <span>System-generated report</span>
        </div>

    </div>

</section>

<script>
    function updateReportStatus() {
        const type = document.getElementById('type').value;
        const status = document.getElementById('status');

        const choices = {
            pets: ['Available', 'Unavailable', 'Adopted'],
            adopters: [],
            applications: ['Pending', 'Approved', 'Rejected'],
            records: ['Approved', 'Rejected']
        };

        const current = status.value;

        status.innerHTML = '<option value="">All statuses</option>';

        choices[type].forEach(function (choice) {
            const option = document.createElement('option');
            option.value = choice;
            option.textContent = choice;

            if (choice === current) {
                option.selected = true;
            }

            status.appendChild(option);
        });

        status.disabled = type === 'adopters';
    }

    updateReportStatus();
</script>

@endsection
