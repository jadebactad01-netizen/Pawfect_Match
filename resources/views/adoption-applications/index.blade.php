@extends('layouts.app')

@section('title', 'My Applications - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50 py-12">

    <div class="mx-auto max-w-6xl px-6">

        {{-- Page heading --}}
        <div>

            <p class="font-semibold text-orange-500">
                Adoption
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                My Applications
            </h1>

            <p class="mt-3 text-gray-600">
                View the status of your submitted adoption applications.
            </p>

        </div>


        @if ($applications->isEmpty())

            {{-- No applications yet --}}
            <div class="mt-10 rounded-3xl bg-white
                        p-8 text-center shadow-sm sm:p-12">

                <div class="text-6xl">
                    🐾
                </div>

                <h2 class="mt-5 text-2xl font-bold text-gray-900">
                    No Applications Yet
                </h2>

                <p class="mx-auto mt-3 max-w-lg text-gray-600">
                    You haven't submitted an adoption application yet.
                    Browse the available pets and find your pawfect match.
                </p>

                <a href="{{ route('pets.index') }}"
                   class="mt-7 inline-block rounded-full
                          bg-orange-500 px-8 py-3
                          font-semibold text-white
                          hover:bg-orange-600">

                    Browse Available Pets

                </a>

            </div>

        @else

            {{-- Applications --}}
            <div class="mt-10 grid gap-6 md:grid-cols-2">

                @foreach ($applications as $application)

                    <div class="rounded-3xl bg-white
                                p-6 shadow-sm sm:p-7">

                        {{-- Top row --}}
                        <div class="flex items-start
                                    justify-between gap-4">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Application #{{ $application->id }}
                                </p>

                                <h2 class="mt-1 text-2xl
                                           font-bold text-gray-900">

                                    {{ $application->pet->name }}

                                </h2>

                            </div>


                            {{-- Status --}}
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

                        </div>


                        {{-- Pet information --}}
                        <div class="mt-6 grid grid-cols-2 gap-4">

                            <div class="rounded-xl bg-gray-50 p-4">

                                <p class="text-sm text-gray-500">
                                    Type
                                </p>

                                <p class="mt-1 font-semibold text-gray-900">
                                    {{ $application->pet->type }}
                                </p>

                            </div>


                            <div class="rounded-xl bg-gray-50 p-4">

                                <p class="text-sm text-gray-500">
                                    Age
                                </p>

                                <p class="mt-1 font-semibold text-gray-900">
                                    {{ $application->pet->age }}
                                </p>

                            </div>

                        </div>


                        {{-- Application date --}}
                        <div class="mt-5">

                            <p class="text-sm text-gray-500">
                                Date Submitted
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $application->created_at->format('F d, Y') }}
                            </p>

                        </div>


                        {{-- Status explanation --}}
                        <div class="mt-5 rounded-xl p-4

                            @if ($application->status === 'Approved')
                                bg-green-50

                            @elseif ($application->status === 'Rejected')
                                bg-red-50

                            @else
                                bg-yellow-50
                            @endif
                        ">

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

                                <p class="text-sm leading-6 text-yellow-700">
                                    Your application is waiting for review
                                    by Bayambang Animal Shelter.
                                </p>

                            @endif

                        </div>


                        {{-- View pet --}}
                        <a href="{{ route('pets.show', $application->pet) }}"
                           class="mt-6 inline-block font-semibold
                                  text-orange-500 hover:text-orange-600">

                            View {{ $application->pet->name }} →

                        </a>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection