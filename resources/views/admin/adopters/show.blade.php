@extends('layouts.app')

@section('title', 'Adopter Details')

@section('content')

<section class="mx-auto max-w-5xl px-6 py-10">

    <a
        href="{{ route('admin.adopters.index') }}"
        class="text-sm font-semibold text-orange-500 hover:text-orange-600"
    >
        ← Back to Adopters
    </a>

    {{-- ADOPTER INFORMATION --}}
    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">

        <h1 class="text-2xl font-bold text-gray-900">
            {{ $adopter->name }}
        </h1>

        <div class="mt-6 grid gap-5 md:grid-cols-2">

            <div>
                <p class="text-sm font-semibold text-gray-500">
                    Email
                </p>

                <p class="mt-1 text-gray-900">
                    {{ $adopter->email }}
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500">
                    Phone Number
                </p>

                <p class="mt-1 text-gray-900">
                    {{ $adopter->adopterProfile?->phone_number ?? 'Not provided' }}
                </p>
            </div>

            <div class="md:col-span-2">
                <p class="text-sm font-semibold text-gray-500">
                    Address
                </p>

                <p class="mt-1 text-gray-900">
                    {{ $adopter->adopterProfile?->address ?? 'Not provided' }}
                </p>
            </div>

        </div>
    </div>

    {{-- ASSESSMENT EDIT REQUEST --}}
    @if ($adopter->adopterProfile?->edit_request_status)

        <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm">

            <h2 class="text-xl font-bold text-gray-900">
                Compatibility Assessment Edit Request
            </h2>

            <p class="mt-3 text-sm text-gray-600">
                Request Status:
                <span class="font-semibold text-orange-600">
                    {{ $adopter->adopterProfile->edit_request_status }}
                </span>
            </p>

            <div class="mt-5 rounded-xl bg-gray-50 p-5">

                <p class="font-semibold text-gray-800">
                    Reason for Request
                </p>

                <p class="mt-2 whitespace-pre-line text-gray-700">
                    {{ $adopter->adopterProfile->edit_request_reason }}
                </p>

            </div>

            @if ($adopter->adopterProfile->edit_request_status === 'Pending')

                <div class="mt-5 flex flex-wrap gap-3">

                    <form
                        action="{{ route('admin.adopters.review-edit-request', $adopter) }}"
                        method="POST"
                    >
                        @csrf

                        <input type="hidden" name="decision" value="Approved">

                        <button
                            type="submit"
                            class="rounded-full bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700"
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
                            class="rounded-full bg-red-500 px-6 py-3 font-semibold text-white hover:bg-red-600"
                        >
                            Reject Request
                        </button>
                    </form>

                </div>

            @endif
        </div>
    @endif

    {{-- ADOPTION APPLICATIONS --}}
    <div class="mt-8">

        <h2 class="text-xl font-bold text-gray-900">
            Adoption Applications
        </h2>

        @if ($adopter->adoptionApplications->isEmpty())

            <div class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-gray-600">
                    This adopter has not submitted any applications.
                </p>
            </div>

        @else

            <div class="mt-4 space-y-4">

                @foreach (
                    $adopter->adoptionApplications->sortByDesc('created_at')
                    as $application
                )

                    <div class="rounded-2xl bg-white p-6 shadow-sm">

                        <div class="flex flex-wrap items-center justify-between gap-4">

                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $application->pet?->name ?? 'Pet unavailable' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-600">
                                    Status: {{ $application->status }}
                                </p>

                                @if ($application->compatibilityAssessment)

                                    <p class="mt-1 text-sm text-gray-600">
                                        Compatibility:
                                        {{ $application->compatibilityAssessment->total_score }}%
                                    </p>

                                @endif
                            </div>

                            @if ($application->compatibilityAssessment)

                                <a
                                    href="{{ route('admin.applications.show', $application) }}"
                                    class="font-semibold text-orange-500 hover:text-orange-600"
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

</section>

@endsection