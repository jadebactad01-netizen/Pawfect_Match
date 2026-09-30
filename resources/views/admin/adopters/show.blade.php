@extends('layouts.app')

@section('title', 'Adopter Details')

@section('content')

    <section class="mx-auto max-w-5xl px-6 py-10">

        <a
            href="{{ route('admin.adopters.index') }}"
            class="text-sm font-semibold text-orange-500
                   hover:text-orange-600"
        >
            ← Back to Adopters
        </a>


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
                        {{ $adopter->adopterProfile?->phone_number
                            ?? 'Not provided' }}
                    </p>
                </div>


                <div class="md:col-span-2">

                    <p class="text-sm font-semibold text-gray-500">
                        Address
                    </p>

                    <p class="mt-1 text-gray-900">
                        {{ $adopter->adopterProfile?->address
                            ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>


        <div class="mt-8">

            <h2 class="text-xl font-bold text-gray-900">
                Adoption Applications
            </h2>


            @if ($adopter->adoptionApplications->isEmpty())

                <div class="mt-4 rounded-2xl bg-white
                            p-6 shadow-sm">

                    <p class="text-gray-600">
                        This adopter has not submitted
                        any applications.
                    </p>

                </div>

            @else

                <div class="mt-4 space-y-4">

                    @foreach (
                        $adopter->adoptionApplications
                            ->sortByDesc('created_at')
                        as $application
                    )

                        <div class="rounded-2xl bg-white
                                    p-6 shadow-sm">

                            <div class="flex flex-wrap items-center
                                        justify-between gap-4">

                                <div>

                                    <p class="font-semibold text-gray-900">
                                        {{ $application->pet->name }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        Status:
                                        {{ $application->status }}
                                    </p>

                                    @if (
                                        $application
                                            ->compatibilityAssessment
                                    )

                                        <p class="mt-1 text-sm
                                                  text-gray-600">
                                            Compatibility:
                                            {{
                                                $application
                                                    ->compatibilityAssessment
                                                    ->total_score
                                            }}%
                                        </p>

                                    @endif

                                </div>


                                @if (
                                    $application
                                        ->compatibilityAssessment
                                )

                                    <a
                                        href="{{ route(
                                            'admin.applications.show',
                                            $application
                                        ) }}"
                                        class="font-semibold
                                               text-orange-500
                                               hover:text-orange-600"
                                    >
                                        View Application
                                    </a>

                                @else

                                    <span class="text-sm text-gray-500">
                                        Assessment not completed
                                    </span>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </section>

@endsection
