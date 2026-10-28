@extends('layouts.app')

@section('title', 'Adopter Details - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Adopter Details
            </h1>

            <p class="mt-2 text-sm leading-6 text-gray-600">
                View {{ $adopter->name }}'s profile, compatibility assessment requests, and adoption history.
            </p>

            <a
                href="{{ route('admin.adopters.index') }}"
                class="mt-4 inline-flex items-center text-sm font-semibold text-orange-600 hover:text-orange-700"
            >
                ← Back to Adopters
            </a>

        </div>

        {{-- ADOPTER INFORMATION --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-orange-100 pb-4">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Adopter Profile
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        {{ $adopter->name }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Registered adopter information
                    </p>

                </div>

                <span class="rounded-full border px-3 py-1 text-xs font-semibold
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

            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>

                    <p class="text-sm font-semibold text-gray-500">
                        Full Name
                    </p>

                    <p class="mt-1 break-words text-sm font-medium text-gray-900">
                        {{ $adopter->name }}
                    </p>

                </div>

                <div>

                    <p class="text-sm font-semibold text-gray-500">
                        Email Address
                    </p>

                    <p class="mt-1 break-all text-sm font-medium text-gray-900">
                        {{ $adopter->email }}
                    </p>

                </div>

                <div>

                    <p class="text-sm font-semibold text-gray-500">
                        Phone Number
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $adopter->adopterProfile?->phone_number ?? 'Not provided' }}
                    </p>

                </div>

                <div>

                    <p class="text-sm font-semibold text-gray-500">
                        Age
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $adopter->adopterProfile?->age ?? 'Not provided' }}
                    </p>

                </div>

                <div class="sm:col-span-2">

                    <p class="text-sm font-semibold text-gray-500">
                        Address
                    </p>

                    <p class="mt-1 break-words text-sm font-medium leading-6 text-gray-900">
                        {{ $adopter->adopterProfile?->address ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- COMPATIBILITY ASSESSMENT EDIT REQUEST --}}
        @if ($adopter->adopterProfile?->edit_request_status)

            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-orange-100 pb-4">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                            Assessment Management
                        </p>

                        <h2 class="mt-1 text-xl font-bold text-gray-900">
                            Compatibility Assessment Edit Request
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Review the adopter's request to update their assessment.
                        </p>

                    </div>

                    <span class="rounded-full border px-3 py-1 text-xs font-semibold
                        @if ($adopter->adopterProfile->edit_request_status === 'Approved')
                            border-green-200 bg-green-50 text-green-700
                        @elseif ($adopter->adopterProfile->edit_request_status === 'Rejected')
                            border-red-200 bg-red-50 text-red-700
                        @elseif ($adopter->adopterProfile->edit_request_status === 'Pending')
                            border-amber-200 bg-amber-50 text-amber-700
                        @else
                            border-gray-200 bg-gray-50 text-gray-700
                        @endif"
                    >
                        {{ $adopter->adopterProfile->edit_request_status }}
                    </span>

                </div>

                {{-- REASON FOR REQUEST --}}
                <div class="mt-5 rounded-xl border border-orange-100 bg-orange-50/50 p-5">

                    <p class="text-sm font-semibold text-gray-800">
                        Reason for Request
                    </p>

                    <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-gray-700">
                        {{ $adopter->adopterProfile->edit_request_reason ?: 'No reason provided.' }}
                    </p>

                </div>

                {{-- APPROVE / REJECT ACTIONS --}}
                @if ($adopter->adopterProfile->edit_request_status === 'Pending')

                    <div class="mt-5 flex flex-wrap items-center gap-3">

                        <form
                            action="{{ route('admin.adopters.review-edit-request', $adopter) }}"
                            method="POST"
                        >
                            @csrf

                            <input type="hidden" name="decision" value="Approved">

                            <button
                                type="submit"
                                onclick="return confirm('Approve this compatibility assessment edit request?')"
                                class="rounded-full bg-green-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-700"
                            >
                                Approve Request
                            </button>

                        </form>

                        <form
                            action="{{ route('admin.adopters.review-edit-request', $adopter) }}"
                            method="POST"
                        >
                            @csrf

                            <input type="hidden" name="decision" value="Rejected">

                            <button
                                type="submit"
                                onclick="return confirm('Reject this compatibility assessment edit request?')"
                                class="rounded-full border border-red-200 bg-white px-6 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                            >
                                Reject Request
                            </button>

                        </form>

                    </div>

                @endif

            </div>

        @endif

        {{-- ADOPTION APPLICATIONS --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-orange-100 pb-4">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Application History
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Adoption Applications
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Applications submitted by this adopter.
                    </p>

                </div>

                <span class="rounded-full border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">
                    {{ $adopter->adoptionApplications->count() }}
                    {{ $adopter->adoptionApplications->count() === 1 ? 'Application' : 'Applications' }}
                </span>

            </div>

            @if ($adopter->adoptionApplications->isEmpty())

                <div class="mt-5 rounded-xl border border-orange-100 bg-orange-50/50 p-5">

                    <p class="text-sm text-gray-500">
                        This adopter has not submitted any applications.
                    </p>

                </div>

            @else

                <div class="mt-5 space-y-3">

                    @foreach ($adopter->adoptionApplications->sortByDesc('created_at') as $application)

                        <div class="rounded-xl border border-orange-100 bg-orange-50/40 p-4 sm:p-5">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="min-w-0">

                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $application->pet?->name ?? 'Pet unavailable' }}
                                    </p>

                                    <div class="mt-2 flex flex-wrap items-center gap-3">

                                        {{-- APPLICATION STATUS --}}
                                        <span class="rounded-full border px-3 py-1 text-xs font-semibold
                                            @if ($application->status === 'Approved')
                                                border-green-200 bg-green-50 text-green-700
                                            @elseif ($application->status === 'Rejected')
                                                border-red-200 bg-red-50 text-red-700
                                            @else
                                                border-amber-200 bg-amber-50 text-amber-700
                                            @endif"
                                        >
                                            {{ $application->status }}
                                        </span>

                                        {{-- COMPATIBILITY SCORE --}}
                                        @if ($application->compatibilityAssessment)

                                            <span class="text-sm font-medium text-gray-600">
                                                Compatibility:
                                                <span class="font-semibold text-orange-600">
                                                    {{ $application->compatibilityAssessment->total_score }}%
                                                </span>
                                            </span>

                                        @else

                                            <span class="text-xs text-gray-500">
                                                Assessment not completed
                                            </span>

                                        @endif

                                    </div>

                                </div>

                                {{-- VIEW APPLICATION --}}
                                @if ($application->compatibilityAssessment)

                                    <a
                                        href="{{ route('admin.applications.show', $application) }}"
                                        class="inline-flex shrink-0 items-center justify-center rounded-full border border-orange-300 bg-white px-5 py-2.5 text-sm font-semibold text-orange-600 transition hover:bg-orange-50"
                                    >
                                        View Application
                                    </a>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</section>

@endsection