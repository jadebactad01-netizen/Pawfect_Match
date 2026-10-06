@extends('layouts.app')

@section('title', 'Adoption Records')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        <p class="font-semibold text-orange-500">
            Shelter Management
        </p>

        <h1 class="mt-1 text-3xl font-bold text-gray-900">
            Adoption Records
        </h1>

        <p class="mt-2 text-gray-600">
            View adoption applications that have already
            been evaluated by the shelter.
        </p>


        <!-- FILTERS -->

        <div class="mt-8 flex flex-wrap gap-3">

            <a
                href="{{ route('admin.adoption-records.index') }}"
                class="rounded-full px-5 py-2 text-sm font-semibold
                    {{ ! in_array($status, ['Approved', 'Rejected'])
                        ? 'bg-orange-500 text-white'
                        : 'bg-white text-gray-700 hover:bg-gray-100' }}"
            >
                All Records
            </a>


            <a
                href="{{ route(
                    'admin.adoption-records.index',
                    ['status' => 'Approved']
                ) }}"
                class="rounded-full px-5 py-2 text-sm font-semibold
                    {{ $status === 'Approved'
                        ? 'bg-green-500 text-white'
                        : 'bg-white text-gray-700 hover:bg-green-50' }}"
            >
                Approved
            </a>


            <a
                href="{{ route(
                    'admin.adoption-records.index',
                    ['status' => 'Rejected']
                ) }}"
                class="rounded-full px-5 py-2 text-sm font-semibold
                    {{ $status === 'Rejected'
                        ? 'bg-red-500 text-white'
                        : 'bg-white text-gray-700 hover:bg-red-50' }}"
            >
                Rejected
            </a>

        </div>


        <!-- SEARCH -->

        <form
            action="{{ route('admin.adoption-records.index') }}"
            method="GET"
            class="mt-6 flex max-w-md"
        >

            @if ($status)

                <input
                    type="hidden"
                    name="status"
                    value="{{ $status }}"
                >

            @endif

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


        @if ($records->isEmpty())

            <div class="mt-8 rounded-3xl bg-white
                        p-10 text-center shadow-sm">

                <h2 class="text-xl font-bold text-gray-900">
                    No Adoption Records
                </h2>

                <p class="mt-2 text-gray-600">
                    No matching adoption records found.
                </p>

            </div>

        @else

            <div class="mt-8 space-y-4">

                @foreach ($records as $record)

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
                                        Record
                                    </p>

                                    <p class="mt-1 font-bold text-gray-900">
                                        #{{ $record->id }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-sm text-gray-500">
                                        Applicant
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{ $record->user->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-sm text-gray-500">
                                        Pet
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{ $record->pet->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-sm text-gray-500">
                                        Submitted
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{ $record->created_at->format('M d, Y') }}
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3">

                                <span class="rounded-full px-4 py-2
                                             text-sm font-semibold
                                    {{ $record->status === 'Approved'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}"
                                >
                                    {{ $record->status }}
                                </span>


                                <a
                                    href="{{ route(
                                        'admin.adoption-records.show',
                                        $record
                                    ) }}"
                                    class="rounded-full bg-orange-500
                                           px-5 py-2 text-sm
                                           font-semibold text-white
                                           hover:bg-orange-600"
                                >
                                    View Record
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