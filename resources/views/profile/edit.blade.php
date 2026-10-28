@extends('layouts.app')

@section('title', 'My Profile - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 px-4 py-10 sm:px-6">

    <div class="mx-auto max-w-3xl">

        {{-- PAGE HEADER --}}
        <div class="relative overflow-hidden rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <div class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full border-[18px] border-orange-200/60"></div>

            <div class="relative">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Account Settings
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    My Profile
                </h1>

                <div class="mt-3 h-1 w-12 rounded-full bg-orange-400"></div>

                <p class="mt-4 text-gray-600">
                    Manage your account, animal preferences, and compatibility information.
                </p>

            </div>

        </div>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700">

                <p class="font-semibold">
                    Please check the information below.
                </p>

                <ul class="mt-3 list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        @php
            $assessmentEditable =
                ! $profile?->assessment_locked_at
                || $profile?->edit_permission_granted;

            $ageParts = explode(' ', $profile?->preferred_age ?? '');

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

        {{-- PROFILE FORM --}}
        <form
            action="{{ route('profile.update') }}"
            method="POST"
            class="mt-6 space-y-8 rounded-3xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8"
        >
            @csrf
            @method('PUT')

            {{-- ACCOUNT INFORMATION --}}
            <div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Personal Details
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Account Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Your basic account information.
                    </p>
                </div>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">

                    <div>
                        <label for="name" class="text-sm font-semibold text-gray-700">
                            Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                    </div>

                    <div>
                        <label for="email" class="text-sm font-semibold text-gray-700">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                    </div>

                </div>

            </div>

            @if ($user->role === 'adopter')

                {{-- CONTACT INFORMATION --}}
                <div class="border-t border-orange-100 pt-8">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Contact Details
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Contact Information
                    </h2>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">

                        <div>
                            <label for="age" class="text-sm font-semibold text-gray-700">
                                Age
                            </label>

                            <input
                                type="text"
                                id="age"
                                name="age"
                                inputmode="numeric"
                                maxlength="3"
                                required
                                value="{{ old('age', $profile?->age) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (Number(this.value) > 120) this.value = '120';"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >
                        </div>

                        <div>
                            <label for="phone_number" class="text-sm font-semibold text-gray-700">
                                Mobile Number
                            </label>

                            <input
                                type="text"
                                id="phone_number"
                                name="phone_number"
                                inputmode="numeric"
                                maxlength="11"
                                required
                                value="{{ old('phone_number', $profile?->phone_number) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="text-sm font-semibold text-gray-700">
                                Address
                            </label>

                            <input
                                type="text"
                                id="address"
                                name="address"
                                required
                                value="{{ old('address', $profile?->address) }}"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >
                        </div>

                    </div>

                </div>

                {{-- ANIMAL PREFERENCES --}}
                <div class="border-t border-orange-100 pt-8">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Your Preferences
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Animal Preferences
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Edit your preferences here. They will be shown as read-only
                        information in your adoption application.
                    </p>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">

                        <div>
                            <label for="animal_preference" class="text-sm font-semibold text-gray-700">
                                Are you interested in a:
                            </label>

                            <select
                                id="animal_preference"
                                name="animal_preference"
                                onchange="document.getElementById('animal_preference_other').disabled = this.value !== 'Other'"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >
                                <option value="">Select an option</option>

                                @foreach (['Cat', 'Kitten', 'Dog', 'Puppy', 'Other'] as $animal)
                                    <option
                                        value="{{ $animal }}"
                                        @selected(old('animal_preference', $profile?->animal_preference) === $animal)
                                    >
                                        {{ $animal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="animal_preference_other" class="text-sm font-semibold text-gray-700">
                                If Other, please specify
                            </label>

                            <input
                                type="text"
                                id="animal_preference_other"
                                name="animal_preference_other"
                                value="{{ old('animal_preference_other', $profile?->animal_preference_other) }}"
                                @disabled(old('animal_preference', $profile?->animal_preference) !== 'Other')
                                oninput="this.value = this.value.replace(/[^\p{L}\s.'-]/gu, '')"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400"
                            >
                        </div>

                        <div>
                            <label for="preferred_breed" class="text-sm font-semibold text-gray-700">
                                Breed / Mix
                            </label>

                            <input
                                type="text"
                                id="preferred_breed"
                                name="preferred_breed"
                                value="{{ old('preferred_breed', $profile?->preferred_breed) }}"
                                oninput="this.value = this.value.replace(/[^\p{L}\s'-]/gu, '')"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                            >
                        </div>

                        <div>
                            <label for="preferred_size" class="text-sm font-semibold text-gray-700">
                                Preferred Size
                            </label>

                            <select
                                id="preferred_size"
                                name="preferred_size"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-700 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
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

                        <div class="sm:col-span-2">
                            <label for="preferred_age_number" class="text-sm font-semibold text-gray-700">
                                Preferred Age
                            </label>

                            <div class="mt-2 flex gap-3">

                                <input
                                    type="text"
                                    id="preferred_age_number"
                                    name="preferred_age_number"
                                    inputmode="numeric"
                                    maxlength="2"
                                    placeholder="Age"
                                    value="{{ old('preferred_age_number', $ageParts[0]) }}"
                                    oninput="
                                        this.value = this.value.replace(/[^0-9]/g, '');
                                        if (Number(this.value) > (document.getElementById('preferred_age_unit').value === 'Months' ? 11 : 30)) this.value = '';
                                    "
                                    class="min-w-0 flex-1 rounded-xl border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >

                                <select
                                    id="preferred_age_unit"
                                    name="preferred_age_unit"
                                    onchange="document.getElementById('preferred_age_number').value = ''"
                                    class="rounded-xl border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
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
                <div class="border-t border-orange-100 pt-8">

                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                                Lifestyle and Pet Care
                            </p>

                            <h2 class="mt-1 text-xl font-bold text-gray-900">
                                Compatibility Assessment
                            </h2>
                        </div>

                        @if ($assessmentEditable)
                            <span class="rounded-full border border-green-200 bg-green-50 px-3 py-1 text-sm font-semibold text-green-700">
                                Editable
                            </span>
                        @else
                            <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-sm font-semibold text-gray-600">
                                Locked
                            </span>
                        @endif

                    </div>

                    @if (! $profile?->assessment_locked_at)

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Complete all six questions. After saving for the first time,
                            your answers will be locked.
                        </p>

                    @elseif ($profile?->edit_permission_granted)

                        <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                            Your edit request has been approved.
                            You can change your answers once.
                            They will lock again after saving.
                        </div>

                    @else

                        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600">
                            Your compatibility assessment is locked.
                            You may view your answers but cannot change them
                            without administrator approval.
                        </div>

                    @endif

                    <div class="mt-6 space-y-4">

                        @foreach ($questions as $field => $question)

                            <div class="rounded-xl border border-orange-100 bg-orange-50/40 p-4">

                                <label
                                    for="{{ $field }}"
                                    class="text-sm font-semibold text-gray-800"
                                >
                                    {{ $loop->iteration }}. {{ $question[0] }}
                                </label>

                                <p class="mt-1 text-sm leading-6 text-gray-500">
                                    {{ $question[1] }}
                                </p>

                                <select
                                    id="{{ $field }}"
                                    name="{{ $field }}"
                                    @disabled(! $assessmentEditable)
                                    @if ($assessmentEditable) required @endif
                                    class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100 disabled:cursor-not-allowed disabled:border-orange-100 disabled:bg-gray-100 disabled:text-gray-600"
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
            <div class="border-t border-orange-100 pt-8">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Account Security
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Change Password
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Leave these fields blank if you do not want to change your password.
                </p>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">

                    <div>
                        <label for="password" class="text-sm font-semibold text-gray-700">
                            New Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-sm font-semibold text-gray-700">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >
                    </div>

                </div>

            </div>

            {{-- SAVE BUTTON --}}
            <div class="flex justify-end border-t border-orange-100 pt-6">

                <button
                    type="submit"
                    class="w-full rounded-full bg-orange-500 px-7 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md sm:w-auto"
                >
                    Save Changes
                </button>

            </div>

        </form>

        {{-- REQUEST PERMISSION TO EDIT ASSESSMENT --}}
        @if ($user->role === 'adopter' && $profile?->assessment_locked_at)

            <div class="mt-8 rounded-3xl border border-orange-100 bg-white p-6 shadow-sm sm:p-8">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                    Assessment Management
                </p>

                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Request Permission to Edit Assessment
                </h2>

                @if ($profile->edit_permission_granted)

                    <div class="mt-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                        Your request has been approved.
                        You can now edit your compatibility assessment above.
                    </div>

                @elseif ($profile->edit_request_status === 'Pending')

                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
                        Your request is pending administrator review.
                        Your assessment remains locked.
                    </div>

                @else

                    @if ($profile->edit_request_status === 'Rejected')

                        <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                            Your previous request was rejected.
                            You may submit another request with a reason.
                        </div>

                    @elseif ($profile->edit_request_status === 'Completed')

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Your previous approved edit was completed.
                            You can request permission again if necessary.
                        </p>

                    @endif

                    <form
                        action="{{ route('profile.request-edit') }}"
                        method="POST"
                        class="mt-5"
                    >
                        @csrf

                        <label for="reason" class="text-sm font-semibold text-gray-700">
                            Reason for requesting a change
                        </label>

                        <textarea
                            id="reason"
                            name="reason"
                            rows="4"
                            minlength="10"
                            maxlength="1000"
                            required
                            placeholder="Explain why you need to change your compatibility information..."
                            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                        >{{ old('reason') }}</textarea>

                        <p class="mt-2 text-sm text-gray-500">
                            Only the shelter's Admin and Super Admin can
                            read your reason and review your request.
                        </p>

                        <button
                            type="submit"
                            class="mt-4 rounded-full bg-orange-500 px-6 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                        >
                            Submit Request
                        </button>

                    </form>

                @endif

            </div>

        @endif

    </div>

</section>

@endsection