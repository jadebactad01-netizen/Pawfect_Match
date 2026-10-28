@extends('layouts.app')

@section('title', 'My Applications - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-6xl px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="relative overflow-hidden rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <div class="relative">

                <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                    My Adoption Journey
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                    My Applications
                </h1>

                <div class="mt-3 h-1 w-12 rounded-full bg-orange-400"></div>

                <p class="mt-4 text-gray-600">
                    View the status of your submitted adoption applications.
                </p>

            </div>

        </div>

        @if ($applications->isEmpty())

            {{-- NO APPLICATIONS --}}
            <div class="mt-8 rounded-3xl border border-orange-100 bg-white p-8 text-center shadow-sm sm:p-12">

                <div class="mx-auto mb-5 h-1 w-14 rounded-full bg-orange-400"></div>

                <h2 class="text-2xl font-bold text-gray-900">
                    No Applications Yet
                </h2>

                <p class="mx-auto mt-3 max-w-lg leading-7 text-gray-600">
                    You haven't submitted an adoption application yet.
                    Browse the available pets and find your pawfect match.
                </p>

                <a
                    href="{{ route('pets.index') }}"
                    class="mt-7 inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                >
                    Browse Available Pets
                </a>

            </div>

        @else

            {{-- APPLICATION CARDS --}}
            <div class="mt-8 grid items-start gap-6 md:grid-cols-2">

                @foreach ($applications as $application)

                    <div class="overflow-hidden rounded-3xl border border-orange-100 bg-white p-6 shadow-sm transition duration-200 hover:border-orange-200 hover:shadow-md sm:p-7">

                        {{-- APPLICATION HEADER --}}
                        <div class="flex flex-wrap items-start justify-between gap-3">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                                    Application #{{ $application->id }}
                                </p>

                                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                    {{ $application->pet->name }}
                                </h2>

                            </div>

                            {{-- APPLICATION STATUS --}}
                            <span class="rounded-full border px-4 py-2 text-sm font-semibold
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

                        </div>

                        {{-- PET INFORMATION --}}
                        <div class="mt-6 grid grid-cols-2 gap-3">

                            <div class="rounded-xl border border-orange-100 bg-orange-50/60 p-4">

                                <p class="text-sm text-gray-500">
                                    Type
                                </p>

                                <p class="mt-1 font-semibold text-gray-900">
                                    {{ $application->pet->type }}
                                </p>

                            </div>

                            <div class="rounded-xl border border-orange-100 bg-orange-50/60 p-4">

                                <p class="text-sm text-gray-500">
                                    Age
                                </p>

                                @php
                                    $petAge = trim($application->pet->age);

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

                                <p class="mt-1 font-semibold text-gray-900">
                                    {{ $formattedAge }}
                                </p>

                            </div>

                        </div>

                        {{-- DATE SUBMITTED --}}
                        <div class="mt-5 border-b border-orange-100 pb-5">

                            <p class="text-sm text-gray-500">
                                Date Submitted
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $application->created_at->format('F d, Y') }}
                            </p>

                        </div>

                        {{-- COMPATIBILITY ASSESSMENT --}}
                        @if ($application->compatibilityAssessment)

                            <div class="mt-5 overflow-hidden rounded-2xl border border-orange-100 bg-orange-50/50">

                                {{-- COMPATIBILITY SCORE --}}
                                <div class="p-5">

                                    <p class="text-sm font-semibold text-gray-700">
                                        Compatibility with {{ $application->pet->name }}
                                    </p>

                                    <div class="mt-3 flex flex-wrap items-center gap-3">

                                        <span class="text-2xl font-bold text-orange-600">
                                            {{ $application->compatibilityAssessment->total_score }}%
                                        </span>

                                        <span class="rounded-full border border-green-200 bg-green-50 px-3 py-1 text-sm font-semibold text-green-700">
                                            {{ $application->compatibilityAssessment->classification }}
                                        </span>

                                    </div>

                                </div>

                                {{-- COMPATIBILITY EXPLANATION --}}
                                <div class="border-t border-orange-100 bg-white p-5">

                                    <h3 class="font-semibold text-gray-900">
                                        Compatibility Explanation
                                    </h3>

                                    @if ($application->compatibilityAssessment->gemini_explanation)

                                        <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">
                                            {{ $application->compatibilityAssessment->gemini_explanation }}
                                        </p>

                                    @else

                                        <p class="mt-3 text-sm leading-7 text-gray-600">
                                            The AI model is temporarily unavailable.
                                            Your compatibility score is still valid.
                                            You can try generating the explanation again later.
                                        </p>

                                        <form
                                            action="{{ route(
                                                'compatibility-assessments.retry-explanation',
                                                $application
                                            ) }}"
                                            method="POST"
                                            class="mt-4"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="rounded-full bg-orange-500 px-5 py-2 text-sm font-semibold text-white transition duration-200 hover:bg-orange-600 hover:shadow-sm"
                                            >
                                                Retry AI Explanation
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>

                        @else

                            {{-- INCOMPLETE ASSESSMENT --}}
                            <div class="mt-5 rounded-2xl border border-orange-200 bg-orange-50 p-5">

                                <p class="font-semibold text-orange-700">
                                    Compatibility Assessment Incomplete
                                </p>

                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                    Complete the assessment to finish your
                                    adoption application.
                                </p>

                                <a
                                    href="{{ route(
                                        'compatibility-assessments.create',
                                        $application
                                    ) }}"
                                    class="mt-4 inline-block rounded-full bg-orange-500 px-5 py-2 text-sm font-semibold text-white transition duration-200 hover:bg-orange-600 hover:shadow-sm"
                                >
                                    Continue Assessment
                                </a>

                            </div>

                        @endif

                        {{-- OTHER COMPATIBLE PETS --}}
                        @if (
                            $application->compatibilityAssessment &&
                            $application->compatibilityAssessment
                                ->petRecommendations
                                ->isNotEmpty()
                        )

                            <div class="mt-6">

                                <div class="border-b border-orange-100 pb-3">

                                    <h3 class="font-bold text-gray-900">
                                        Other Compatible Pets
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-gray-500">
                                        Based on your compatibility assessment,
                                        these available pets may also be a good match for you.
                                    </p>

                                </div>

                                <div class="mt-4 space-y-3">

                                    @foreach (
                                        $application->compatibilityAssessment
                                            ->petRecommendations
                                            ->sortByDesc('compatibility_score')
                                        as $recommendation
                                    )

                                        {{-- RECOMMENDATION CARD --}}
                                        <div class="rounded-2xl border border-orange-100 bg-orange-50/50 p-4">

                                            <div class="flex flex-wrap items-start justify-between gap-3">

                                                <div>

                                                    <p class="font-semibold text-gray-900">
                                                        {{ $recommendation->pet->name }}
                                                    </p>

                                                    @php
                                                        $recommendedAge = trim($recommendation->pet->age);

                                                        $formattedRecommendedAge = preg_replace_callback(
                                                            '/^(\d+)\s+(year|month)s?$/i',
                                                            function ($matches) {
                                                                return $matches[1] . ' ' .
                                                                    strtolower($matches[2]) .
                                                                    ($matches[1] == 1 ? '' : 's') .
                                                                    ' old';
                                                            },
                                                            $recommendedAge
                                                        );
                                                    @endphp

                                                    <p class="mt-1 text-sm text-gray-600">
                                                        {{ $recommendation->pet->type }}
                                                        · {{ $formattedRecommendedAge }}
                                                    </p>

                                                </div>

                                                <div class="text-right">

                                                    <p class="font-bold text-orange-600">
                                                        {{ $recommendation->compatibility_score }}%
                                                    </p>

                                                    <p class="mt-1 text-xs text-gray-600">
                                                        {{ $recommendation->classification }}
                                                    </p>

                                                </div>

                                            </div>

                                            {{-- AI RECOMMENDATION EXPLANATION --}}
                                            <div class="mt-4 border-t border-orange-100 pt-3">

                                                @if ($recommendation->gemini_explanation)

                                                    <p class="text-sm leading-6 text-gray-600">
                                                        {{ $recommendation->gemini_explanation }}
                                                    </p>

                                                @else

                                                    <p class="text-sm text-gray-500">
                                                        AI recommendation explanation
                                                        is temporarily unavailable.
                                                    </p>

                                                @endif

                                            </div>

                                            {{-- VIEW RECOMMENDED PET --}}
                                            <a
                                                href="{{ route(
                                                    'pets.show',
                                                    $recommendation->pet
                                                ) }}"
                                                class="mt-4 inline-block text-sm font-semibold text-orange-600 transition hover:text-orange-700"
                                            >
                                                View {{ $recommendation->pet->name }} →
                                            </a>

                                        </div>

                                    @endforeach

                                </div>

                                {{-- RETRY MISSING RECOMMENDATION EXPLANATIONS --}}
                                @if (
                                    $application->compatibilityAssessment
                                        ->petRecommendations
                                        ->contains(fn ($recommendation) =>
                                            empty($recommendation->gemini_explanation)
                                        )
                                )

                                    <form
                                        action="{{ route(
                                            'compatibility-assessments.retry-recommendations',
                                            $application
                                        ) }}"
                                        method="POST"
                                        class="mt-4"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="rounded-full bg-orange-500 px-5 py-2 text-sm font-semibold text-white transition duration-200 hover:bg-orange-600 hover:shadow-sm"
                                        >
                                            Retry AI Recommendation Explanations
                                        </button>

                                    </form>

                                @endif

                            </div>

                        @endif

                        {{-- APPLICATION STATUS MESSAGE --}}
                        <div class="mt-6 rounded-xl border p-4
                            @if ($application->status === 'Approved')
                                border-green-200 bg-green-50
                            @elseif ($application->status === 'Rejected')
                                border-red-200 bg-red-50
                            @else
                                border-amber-200 bg-amber-50
                            @endif"
                        >

                            @if ($application->status === 'Approved')

                                <p class="text-sm leading-6 text-green-700">
                                    Your application has been approved.
                                    Please follow the shelter's instructions
                                    for the next stage of the adoption process.
                                </p>

                            @elseif ($application->status === 'Rejected')

                                <p class="text-sm leading-6 text-red-700">
                                    Your application was not approved.
                                    You may still browse other available pets.
                                </p>

                            @else

                                <p class="text-sm leading-6 text-amber-700">
                                    Your application is waiting for review
                                    by Bayambang Animal Shelter.
                                </p>

                            @endif

                        </div>

                        {{-- VIEW PET PROFILE --}}
                        <div class="mt-5 border-t border-orange-100 pt-4">

                            <a
                                href="{{ route('pets.show', $application->pet) }}"
                                class="inline-block text-sm font-semibold text-orange-600 transition hover:text-orange-700"
                            >
                                View {{ $application->pet->name }} →
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection 