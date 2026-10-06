@extends('layouts.app')

@section('title', 'Adoption Applications - Pawfect Match')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        <div>

            <p class="font-semibold text-orange-500">
                Shelter Management
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Adoption Applications
            </h1>

            <p class="mt-2 text-gray-600">
                Review pending adoption applications
                submitted by adopters.
            </p>

        </div>


        <!-- SEARCH -->

        <form
            action="{{ route('admin.applications.index') }}"
            method="GET"
            class="mt-8 flex max-w-md"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search pet or adopter name..."
                class="min-w-0 flex-1 rounded-l-xl
                       border border-gray-300 bg-white
                       px-4 py-2 outline-none
                       focus:border-orange-500"
            >

            <button
                type="submit"
                class="rounded-r-xl bg-orange-500
                       px-5 py-2 font-semibold text-white
                       hover:bg-orange-600"
            >
                Search
            </button>

        </form>


        @if ($applications->isEmpty())

            <div class="mt-8 rounded-3xl bg-white
                        p-10 text-center shadow-sm">

                <div class="text-5xl">
                    🐾
                </div>

                <h2 class="mt-4 text-xl font-bold text-gray-900">
                    No Pending Applications
                </h2>

                <p class="mt-2 text-gray-600">
                    No matching pending applications found.
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

                            <div class="grid flex-1 gap-5
                                        sm:grid-cols-2
                                        lg:grid-cols-4">

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

                                    <p class="mt-1 font-semibold
                                              text-gray-900">
                                        {{ $application->user->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-sm text-gray-500">
                                        Pet
                                    </p>

                                    <p class="mt-1 font-semibold
                                              text-gray-900">
                                        {{ $application->pet->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-sm text-gray-500">
                                        Submitted
                                    </p>

                                    <p class="mt-1 font-semibold
                                              text-gray-900">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </p>

                                </div>

                            </div>


                            <div class="flex flex-wrap
                                        items-center gap-3">

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
                                           px-5 py-2 text-sm
                                           font-semibold text-white
                                           hover:bg-orange-600"
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