@extends('layouts.app')

@section('title', 'Add Pet - Pawfect Match')


@section('content')


<section class="bg-orange-50 py-12">

    <div class="mx-auto max-w-3xl px-6">


        <a href="{{ route('admin.pets.manage') }}"
           class="font-semibold text-orange-500
                  hover:text-orange-600">

            ← Back to Manage Pets

        </a>


        <div class="mt-8 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-10">

            <p class="font-semibold text-orange-500">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Add a Pet
            </h1>

            <p class="mt-3 text-gray-600">
                Enter the pet's basic information below.
            </p>



            <!-- VALIDATION ERRORS -->

            @if ($errors->any())

                <div class="mt-6 rounded-2xl
                            bg-red-50 p-5 text-red-700">

                    <p class="font-semibold">
                        Please check the information below.
                    </p>

                    <ul class="mt-2 list-disc pl-5">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            <form action="{{ route('admin.pets.store') }}"
                  method="POST"
                  class="mt-8 space-y-6">

                @csrf


                <!-- NAME -->

                <div>

                    <label for="name"
                           class="font-semibold text-gray-700">

                        Pet Name

                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3
                                  focus:border-orange-500
                                  focus:outline-none">

                </div>



                <!-- TYPE + SEX -->

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>

                        <label for="type"
                               class="font-semibold text-gray-700">
                            Type
                        </label>

                        <select id="type"
                                name="type"
                                required
                                class="mt-2 w-full rounded-xl
                                       border border-gray-300
                                       px-4 py-3">

                            <option value="">
                                Select type
                            </option>

                            <option value="Dog"
                                @selected(old('type') === 'Dog')>
                                Dog
                            </option>

                            <option value="Cat"
                                @selected(old('type') === 'Cat')>
                                Cat
                            </option>

                        </select>

                    </div>


                    <div>

                        <label for="sex"
                               class="font-semibold text-gray-700">
                            Sex
                        </label>

                        <select id="sex"
                                name="sex"
                                required
                                class="mt-2 w-full rounded-xl
                                       border border-gray-300
                                       px-4 py-3">

                            <option value="">
                                Select sex
                            </option>

                            <option value="Male"
                                @selected(old('sex') === 'Male')>
                                Male
                            </option>

                            <option value="Female"
                                @selected(old('sex') === 'Female')>
                                Female
                            </option>

                        </select>

                    </div>

                </div>



                <!-- AGE -->

                <div>

                    <label for="age"
                           class="font-semibold text-gray-700">
                        Age
                    </label>

                    <input type="text"
                           id="age"
                           name="age"
                           value="{{ old('age') }}"
                           placeholder="Example: 2 years old"
                           required
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3">

                </div>



                <!-- STATUS -->

                <div>

                    <label for="status"
                           class="font-semibold text-gray-700">
                        Adoption Status
                    </label>

                    <select id="status"
                            name="status"
                            required
                            class="mt-2 w-full rounded-xl
                                   border border-gray-300
                                   px-4 py-3">

                        <option value="Available"
                            @selected(old('status', 'Available') === 'Available')>
                            Available
                        </option>

                        <option value="Unavailable"
                            @selected(old('status') === 'Unavailable')>
                            Unavailable
                        </option>

                    </select>

                </div>



                <!-- DESCRIPTION -->

                <div>

                    <label for="description"
                           class="font-semibold text-gray-700">
                        Description
                    </label>

                    <textarea id="description"
                              name="description"
                              rows="5"
                              class="mt-2 w-full rounded-xl
                                     border border-gray-300
                                     px-4 py-3">{{ old('description') }}</textarea>

                </div>



                <!-- SUBMIT -->

                <button type="submit"
                        class="w-full rounded-full
                               bg-orange-500 px-6 py-3
                               font-semibold text-white
                               hover:bg-orange-600">

                    Add Pet

                </button>

            </form>

        </div>

    </div>

</section>


@endsection