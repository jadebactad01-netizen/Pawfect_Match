@extends('layouts.app')

@section('title', 'Manage Administrators')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-6xl px-6">

        <div class="flex flex-col gap-4
                    sm:flex-row sm:items-center
                    sm:justify-between">

            <div>

                <p class="font-semibold text-orange-500">
                    Super Administration
                </p>

                <h1 class="mt-1 text-3xl font-bold text-gray-900">
                    Administrators
                </h1>

                <p class="mt-2 text-gray-600">
                    Manage shelter administrator accounts.
                </p>

            </div>


            <a
                href="{{ route(
                    'super-admin.administrators.create'
                ) }}"
                class="rounded-full bg-orange-500
                       px-5 py-3 text-center font-semibold
                       text-white hover:bg-orange-600"
            >
                Add Administrator
            </a>

        </div>


        @if ($administrators->isEmpty())

            <div class="mt-8 rounded-2xl bg-white
                        p-8 text-center shadow-sm">

                <p class="text-gray-600">
                    No administrator accounts found.
                </p>

            </div>

        @else

            <div class="mt-8 overflow-hidden rounded-2xl
                        bg-white shadow-sm">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-orange-50">

                            <tr>
                                <th class="px-6 py-4">
                                    Name
                                </th>

                                <th class="px-6 py-4">
                                    Email
                                </th>

                                <th class="px-6 py-4">
                                    Created
                                </th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach (
                                $administrators
                                as $administrator
                            )

                                <tr>

                                    <td class="px-6 py-4
                                               font-semibold">
                                        {{ $administrator->name }}
                                    </td>

                                    <td class="px-6 py-4
                                               text-gray-600">
                                        {{ $administrator->email }}
                                    </td>

                                    <td class="px-6 py-4
                                               text-gray-600">
                                        {{
                                            $administrator
                                                ->created_at
                                                ->format('M d, Y')
                                        }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </div>

</section>

@endsection