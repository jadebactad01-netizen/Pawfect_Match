@extends('layouts.app')

@section('title', 'Adoption Applications - Pawfect Match')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        {{-- Heading --}}
        <div class="flex flex-col gap-4 sm:flex-row
                    sm:items-center sm:justify-between">

            <div>
                <p class="font-semibold text-orange-500">
                    Shelter Management
                </p>

                <h1 class="mt-1 text-3xl font-bold text-gray-900">
                    Adoption Applications
                </h1>

                <p class="mt-2 text-gray-600">
                    Review applications submitted by adopters.
                </p>
            </div>

        </div>


        @if ($applications->isEmpty())

            <div class="mt-8 rounded-3xl bg-white
                        p-10 text-center shadow-sm">

                <div class="text-5xl">
                    🐾
                </div>

                <h2 class="mt-4 text-xl font-bold text-gray-900">
                    No Applications Yet
                </h2>

                <p class="mt-2 text-gray-600">
                    Submitted adoption applications will appear here.
                </p>

            </div>

        @else

            <div class="mt-8 space-y-4">

                @foreach ($applications as $application)

                    <div class="rounded-2xl bg-white
                                p-5 shadow-sm sm:p-6">

                        <div class="flex flex-col gap-5
                                    lg:flex-row lg:items-center
                                    lg:justify-between">

                            {{-- Application information --}}
                            <div class="grid flex-1 gap-5
                                        sm:grid-cols-2 lg:grid-cols-4">

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Application
                                    </p>

                                    <p class="mt-1 font-bold text-gray-900">
                                        #{{ $application->id }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-sm text-gray-500">
                                        Applicant
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $application->user->name }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-sm text-gray-500">
                                        Pet
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $application->pet->name }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-sm text-gray-500">
                                        Submitted
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </p>
                                </div>

                            </div>


                            {{-- Status and button --}}
                            <div class="flex flex-wrap items-center gap-3">

                                <span class="rounded-full px-4 py-2
                                             text-sm font-semibold

                                    @if ($application->status === 'Approved')
                                        bg-green-100 text-green-700

                                    @elseif ($application->status === 'Rejected')
                                        bg-red-100 text-red-700

                                    @else
                                        bg-yellow-100 text-yellow-700
                                    @endif
                                ">
                                    {{ $application->status }}
                                </span>


                                <a
                                    href="{{ route(
                                        'admin.applications.show',
                                        $application
                                    ) }}"
                                    class="rounded-full bg-orange-500
                                           px-5 py-2 text-sm font-semibold
                                           text-white hover:bg-orange-600"
                                >
                                    Review
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection