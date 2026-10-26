@extends('layouts.app')

@section('title', 'My Profile - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-3xl">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                My Profile
            </h1>

            <p class="mt-2 text-gray-600">
                Update your account information, preferences,
                and compatibility assessment answers.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('profile.update') }}"
            method="POST"
            class="space-y-8 rounded-2xl bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf
            @method('PUT')

            {{-- ACCOUNT INFORMATION --}}
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Account Information
                </h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="font-medium text-gray-700">
                            Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        >
                    </div>

                    <div>
                        <label for="email" class="font-medium text-gray-700">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        >
                    </div>
                </div>
            </div>

            @if ($user->role === 'adopter')

                {{-- CONTACT INFORMATION --}}
                <div class="border-t pt-8">
                    <h2 class="text-xl font-bold text-gray-900">
                        Contact Information
                    </h2>

                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="age" class="font-medium text-gray-700">
                                Age
                            </label>

                            <input
                                type="text"
                                id="age"
                                name="age"
                                inputmode="numeric"
                                maxlength="3"
                                value="{{ old('age', $profile?->age) }}"
                                required
                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (Number(this.value) > 120) this.value = '120';"
                                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                            >
                        </div>

                        <div>
                            <label for="phone_number" class="font-medium text-gray-700">
                                Mobile Number
                            </label>

                            <input
                                type="text"
                                id="phone_number"
                                name="phone_number"
                                inputmode="numeric"
                                maxlength="11"
                                value="{{ old('phone_number', $profile?->phone_number) }}"
                                required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="font-medium text-gray-700">
                                Address
                            </label>

                            <input
                                type="text"
                                id="address"
                                name="address"
                                value="{{ old('address', $profile?->address) }}"
                                required
                                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                            >
                        </div>
                    </div>
                </div>

                {{-- ANIMAL PREFERENCES --}}
                <div class="border-t pt-8">
                    <h2 class="text-xl font-bold text-gray-900">
                        Animal Preferences
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        These answers will automatically appear in your adoption application.
                    </p>

                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="animal_preference" class="font-medium text-gray-700">
                                Are you interested in a:
                            </label>

                            <select
                                id="animal_preference"
                                name="animal_preference"
                                onchange="document.getElementById('animal_preference_other').disabled = this.value !== 'Other'"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
                            >
                                <option value="">Select an option</option>

                                @foreach (['Cat', 'Kitten', 'Dog', 'Puppy', 'Other'] as $option)
                                    <option
                                        value="{{ $option }}"
                                        @selected(old('animal_preference', $profile?->animal_preference) === $option)
                                    >
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="animal_preference_other" class="font-medium text-gray-700">
                                If Other, please specify
                            </label>

                            <input
                                type="text"
                                id="animal_preference_other"
                                name="animal_preference_other"
                                value="{{ old('animal_preference_other', $profile?->animal_preference_other) }}"
                                @disabled(old('animal_preference', $profile?->animal_preference) !== 'Other')
                                oninput="this.value = this.value.replace(/[^\p{L}\s.'-]/gu, '')"
                                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 disabled:cursor-not-allowed disabled:bg-gray-100"
                            >
                        </div>

                        <div>
                            <label for="preferred_breed" class="font-medium text-gray-700">
                                Breed / Mix
                            </label>

                            <input
                                type="text"
                                id="preferred_breed"
                                name="preferred_breed"
                                value="{{ old('preferred_breed', $profile?->preferred_breed) }}"
                                oninput="this.value = this.value.replace(/[^\p{L}\s'-]/gu, '')"
                                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                            >
                        </div>

                        <div>
                            <label for="preferred_size" class="font-medium text-gray-700">
                                Preferred Size
                            </label>

                            <select
                                id="preferred_size"
                                name="preferred_size"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
                            >
                                <option value="">Select size</option>

                                @foreach (['Small', 'Medium', 'Large', 'Extra Large'] as $size)
                                    <option
                                        value="{{ $size }}"
                                        @selected(old('preferred_size', $profile?->preferred_size) === $size)
                                    >
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $ageParts = explode(' ', $profile?->preferred_age ?? '');
                        @endphp

                        <div class="sm:col-span-2">
                            <label for="preferred_age_number" class="font-medium text-gray-700">
                                Preferred Age
                            </label>

                            <div class="mt-2 flex gap-3">
                                <input
                                    type="text"
                                    id="preferred_age_number"
                                    name="preferred_age_number"
                                    inputmode="numeric"
                                    maxlength="2"
                                    value="{{ old('preferred_age_number', $ageParts[0]) }}"
                                    placeholder="Age"
                                    oninput="
                                        this.value = this.value.replace(/[^0-9]/g, '');
                                        if (Number(this.value) > (document.getElementById('preferred_age_unit').value === 'Months' ? 11 : 30)) this.value = '';
                                    "
                                    class="min-w-0 flex-1 rounded-xl border border-gray-300 px-4 py-3"
                                >

                                <select
                                    id="preferred_age_unit"
                                    name="preferred_age_unit"
                                    onchange="document.getElementById('preferred_age_number').value = ''"
                                    class="rounded-xl border border-gray-300 bg-white px-4 py-3"
                                >
                                    @foreach (['Months', 'Years'] as $unit)
                                        <option
                                            value="{{ $unit }}"
                                            @selected(old('preferred_age_unit', $ageParts[1] ?? 'Months') === $unit)
                                        >
                                            {{ $unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Months: 1–11 • Years: 1–30
                            </p>
                        </div>
                    </div>
                </div>

                {{-- COMPATIBILITY ASSESSMENT --}}
                <div class="border-t pt-8">
                    <h2 class="text-xl font-bold text-gray-900">
                        Compatibility Assessment
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Save your lifestyle information. You can review or change
                        these answers for each adoption application.
                    </p>

                    @php
                        $questions = [
                            'care_ability' => [
                                'Ability to Provide Proper Care',
                                'How would you describe your ability to provide food, veterinary care, grooming, and other needs?',
                                ['Limited', 'Moderate', 'High'],
                            ],
                            'available_time' => [
                                'Available Time',
                                'How much time can you regularly give to a pet?',
                                ['Low', 'Moderate', 'High'],
                            ],
                            'household_compatibility' => [
                                'Household',
                                'Which best describes your household?',
                                ['Living alone', 'Adults only', 'Family with children'],
                            ],
                            'living_environment' => [
                                'Living Environment',
                                'What type of home do you currently live in?',
                                ['House', 'Apartment', 'Other'],
                            ],
                            'pet_care_experience' => [
                                'Pet-care Experience',
                                'How much experience do you have caring for pets?',
                                ['None', 'Some', 'Experienced'],
                            ],
                            'activity_level' => [
                                'Activity Level',
                                'How would you describe your normal activity level?',
                                ['Low', 'Moderate', 'High'],
                            ],
                        ];
                    @endphp

                    <div class="mt-6 space-y-6">
                        @foreach ($questions as $field => $question)
                            <div>
                                <label for="{{ $field }}" class="font-semibold text-gray-700">
                                    {{ $loop->iteration }}. {{ $question[0] }}
                                </label>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $question[1] }}
                                </p>

                                <select
                                    id="{{ $field }}"
                                    name="{{ $field }}"
                                    class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
                                >
                                    <option value="">Select an answer</option>

                                    @foreach ($question[2] as $option)
                                        <option
                                            value="{{ $option }}"
                                            @selected(old($field, $profile?->$field) === $option)
                                        >
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif

            {{-- CHANGE PASSWORD --}}
            <div class="border-t pt-8">
                <h2 class="text-xl font-bold text-gray-900">
                    Change Password
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Leave these fields blank if you do not want to change your password.
                </p>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="password" class="font-medium text-gray-700">
                            New Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="font-medium text-gray-700">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3"
                        >
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500 px-7 py-3 font-semibold text-white hover:bg-orange-600 sm:w-auto"
                >
                    Save Changes
                </button>
            </div>

        </form>
    </div>

</section>

@endsection