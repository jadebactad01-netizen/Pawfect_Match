@extends('layouts.app')

@section('title', 'Manage Pets - Pawfect Match')


@section('content')


<section class="bg-orange-50 py-12">

    <div class="mx-auto max-w-7xl px-6">

        <div class="flex flex-wrap items-center
                    justify-between gap-4">

            <div>

                <p class="font-semibold text-orange-500">
                    Shelter Management
                </p>

                <h1 class="mt-2 text-4xl font-bold text-gray-900">
                    Manage Pets
                </h1>

                <p class="mt-3 text-gray-600">
                    Add and manage pets in the Pawfect Match system.
                </p>

            </div>


            <a href="{{ route('admin.pets.add') }}"
               class="rounded-full bg-orange-500
                      px-6 py-3 font-semibold text-white
                      hover:bg-orange-600">

                + Add Pet

            </a>

        </div>

    </div>

</section>



<section class="bg-white py-12">

    <div class="mx-auto max-w-7xl px-6">


        <!-- SUCCESS MESSAGE -->

        @if (session('success'))

            <div class="mb-6 rounded-2xl
                        bg-green-100 px-5 py-4
                        text-green-700">

                {{ session('success') }}

            </div>

        @endif


        <div class="overflow-x-auto rounded-2xl
                    border border-gray-200">

            <table class="min-w-full bg-white">

                <thead class="bg-gray-50">

                    <tr class="text-left text-sm text-gray-600">

                        <th class="px-6 py-4">
                            Name
                        </th>

                        <th class="px-6 py-4">
                            Type
                        </th>

                        <th class="px-6 py-4">
                            Sex
                        </th>

                        <th class="px-6 py-4">
                            Age
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($pets as $pet)

                        <tr>

                            <td class="px-6 py-4 font-semibold
                                       text-gray-900">

                                {{ $pet->name }}

                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $pet->type }}
                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $pet->sex }}
                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $pet->age }}
                            </td>


                            <td class="px-6 py-4">

                                <span class="rounded-full
                                             bg-green-100 px-3 py-1
                                             text-sm font-semibold
                                             text-green-700">

                                    {{ $pet->status }}

                                </span>

                            </td>


                            <td class="px-6 py-4">

                                <!-- We will make this work next -->
                                <span class="text-sm text-gray-400">
                                    Edit / Delete coming next
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-12 text-center
                                       text-gray-500">

                                No pets have been added yet.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>


@endsection