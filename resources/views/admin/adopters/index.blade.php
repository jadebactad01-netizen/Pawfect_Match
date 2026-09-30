@extends('layouts.app')

@section('title', 'Manage Adopters')

@section('content')

    <section class="mx-auto max-w-7xl px-6 py-10">

        <div class="mb-8">

            <p class="text-sm font-semibold uppercase
                      tracking-wider text-orange-500">
                Administration
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Registered Adopters
            </h1>

            <p class="mt-2 text-gray-600">
                View registered adopter accounts and
                their adoption activity.
            </p>

        </div>


        @if ($adopters->isEmpty())

            <div class="rounded-2xl bg-white p-8 shadow-sm">

                <p class="text-gray-600">
                    No registered adopters found.
                </p>

            </div>

        @else

            <div class="overflow-hidden rounded-2xl
                        bg-white shadow-sm">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-orange-50 text-sm
                                      text-gray-700">

                            <tr>
                                <th class="px-6 py-4">
                                    Name
                                </th>

                                <th class="px-6 py-4">
                                    Email
                                </th>

                                <th class="px-6 py-4">
                                    Applications
                                </th>

                                <th class="px-6 py-4">
                                    Action
                                </th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach ($adopters as $adopter)

                                <tr>

                                    <td class="px-6 py-4 font-semibold
                                               text-gray-900">
                                        {{ $adopter->name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $adopter->email }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $adopter->adoption_applications_count }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <a
                                            href="{{ route(
                                                'admin.adopters.show',
                                                $adopter
                                            ) }}"
                                            class="font-semibold
                                                   text-orange-500
                                                   hover:text-orange-600"
                                        >
                                            View Details
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </section>

@endsection
