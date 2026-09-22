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
                Enter the pet's information and compatibility requirements below.
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

                <!-- COMPATIBILITY REQUIREMENTS -->

                <div class="border-t border-gray-200 pt-8">

                    <h2 class="text-xl font-bold text-gray-900">
                        Compatibility Requirements
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Describe the type of adopter and home environment
                        that may be suitable for this pet.
                    </p>

                </div>


                <div class="grid gap-6 sm:grid-cols-2">

                    <!-- CARE REQUIREMENT -->

                    <div>
                        <label for="care_requirement"
                            class="font-semibold text-gray-700">
                            Care Requirement
                        </label>

                        <select id="care_requirement"
                                name="care_requirement"
                                required
                                class="mt-2 w-full rounded-xl
                                    border border-gray-300 px-4 py-3">

                            <option value="">Select requirement</option>

                            <option value="Low"
                                @selected(old('care_requirement') === 'Low')>
                                Low
                            </option>

                            <option value="Moderate"
                                @selected(old('care_requirement') === 'Moderate')>
                                Moderate
                            </option>

                            <option value="High"
                                @selected(old('care_requirement') === 'High')>
                                High
                            </option>

                        </select>
                    </div>


                    <!-- TIME REQUIREMENT -->

                    <div>
                        <label for="time_requirement"
                            class="font-semibold text-gray-700">
                            Time Requirement
                        </label>

                        <select id="time_requirement"
                                name="time_requirement"
                                required
                                class="mt-2 w-full rounded-xl
                                    border border-gray-300 px-4 py-3">

                            <option value="">Select requirement</option>

                            <option value="Low"
                                @selected(old('time_requirement') === 'Low')>
                                Low
                            </option>

                            <option value="Moderate"
                                @selected(old('time_requirement') === 'Moderate')>
                                Moderate
                            </option>

                            <option value="High"
                                @selected(old('time_requirement') === 'High')>
                                High
                            </option>

                        </select>
                    </div>


                    <!-- HOUSEHOLD COMPATIBILITY -->

                    <div>
                        <label for="household_compatibility"
                            class="font-semibold text-gray-700">
                            Household Compatibility
                        </label>

                        <select id="household_compatibility"
                                name="household_compatibility"
                                required
                                class="mt-2 w-full rounded-xl
                                    border border-gray-300 px-4 py-3">

                            <option value="">Select household</option>

                            <option value="Living alone"
                                @selected(old('household_compatibility') === 'Living alone')>
                                Living alone
                            </option>

                            <option value="Adults only"
                                @selected(old('household_compatibility') === 'Adults only')>
                                Adults only
                            </option>

                            <option value="Family with children"
                                @selected(old('household_compatibility') === 'Family with children')>
                                Family with children
                            </option>

                            <option value="Any"
                                @selected(old('household_compatibility') === 'Any')>
                                Any household
                            </option>

                        </select>
                    </div>


                    <!-- LIVING ENVIRONMENT -->

                    <div>
                        <label for="living_environment"
                            class="font-semibold text-gray-700">
                            Living Environment
                        </label>

                        <select id="living_environment"
                                name="living_environment"
                                required
                                class="mt-2 w-full rounded-xl
                                    border border-gray-300 px-4 py-3">

                            <option value="">Select environment</option>

                            <option value="House"
                                @selected(old('living_environment') === 'House')>
                                House
                            </option>

                            <option value="Apartment"
                                @selected(old('living_environment') === 'Apartment')>
                                Apartment
                            </option>

                            <option value="Other"
                                @selected(old('living_environment') === 'Other')>
                                Other
                            </option>

                            <option value="Any"
                                @selected(old('living_environment') === 'Any')>
                                Any environment
                            </option>

                        </select>
                    </div>


                    <!-- EXPERIENCE REQUIREMENT -->

                    <div>
                        <label for="experience_requirement"
                            class="font-semibold text-gray-700">
                            Pet Care Experience Required
                        </label>

                        <select id="experience_requirement"
                                name="experience_requirement"
                                required
                                class="mt-2 w-full rounded-xl
                                    border border-gray-300 px-4 py-3">

                            <option value="">Select requirement</option>

                            <option value="None"
                                @selected(old('experience_requirement') === 'None')>
                                No experience required
                            </option>

                            <option value="Some"
                                @selected(old('experience_requirement') === 'Some')>
                                Some experience
                            </option>

                            <option value="Experienced"
                                @selected(old('experience_requirement') === 'Experienced')>
                                Experienced adopter
                            </option>

                        </select>
                    </div>


                    <!-- ACTIVITY LEVEL -->

                    <div>
                        <label for="activity_level"
                            class="font-semibold text-gray-700">
                            Activity Level
                        </label>

                        <select id="activity_level"
                                name="activity_level"
                                required
                                class="mt-2 w-full rounded-xl
                                    border border-gray-300 px-4 py-3">

                            <option value="">Select activity level</option>

                            <option value="Low"
                                @selected(old('activity_level') === 'Low')>
                                Low
                            </option>

                            <option value="Moderate"
                                @selected(old('activity_level') === 'Moderate')>
                                Moderate
                            </option>

                            <option value="High"
                                @selected(old('activity_level') === 'High')>
                                High
                            </option>

                        </select>
                    </div>

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