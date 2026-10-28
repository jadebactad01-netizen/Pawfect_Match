@extends('layouts.app')

@section('title', $pet->name . ' - Pawfect Match')

@section('content')

@php
    $petUrl = route('pets.show', $pet);

    $shareMessage = 'Meet ' . $pet->name .
        '! This ' . strtolower($pet->type) .
        ' is looking for a loving home through Pawfect Match. ' .
        $petUrl;

    $facebookShare = 'https://www.facebook.com/sharer/sharer.php?u=' .
        urlencode($petUrl);

    $whatsappShare = 'https://wa.me/?text=' .
        urlencode($shareMessage);

    $petAge = trim($pet->age);

    $formattedAge = preg_replace_callback(
        '/^(\d+)\s+(year|month)s?$/i',
        function ($matches) {
            return $matches[1] . ' ' .
                strtolower($matches[2]) .
                ($matches[1] == 1 ? '' : 's') .
                ' old';
        },
        $petAge
    );
@endphp

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        {{-- BACK BUTTON --}}
        <a
            href="{{ route('pets.index') }}"
            class="inline-flex items-center gap-2 rounded-full border border-orange-200 bg-white px-4 py-2 text-sm font-semibold text-orange-600 transition duration-200 hover:border-orange-300 hover:bg-orange-50"
        >
            <span>←</span>
            <span>Back to Available Pets</span>
        </a>

        {{-- NOTIFICATIONS --}}
        @if (session('success'))
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- MAIN PET PROFILE --}}
        <div class="mt-6 rounded-3xl border border-orange-100 bg-white p-4 shadow-sm sm:p-6">

            <div class="grid gap-8 lg:grid-cols-2">

                {{-- LEFT SIDE --}}
                <div class="lg:pt-6">

                    {{-- PET IMAGE --}}
                    <div class="overflow-hidden rounded-2xl border border-orange-100 bg-orange-100 shadow-sm">

                        @if ($pet->photo)

                            <img
                                src="{{ asset('storage/' . $pet->photo) }}"
                                alt="{{ $pet->name }}"
                                class="h-[80px] w-full object-cover object-center sm:h-[380px] lg:h-[500px]"
                            >

                        @else

                            <div class="flex h-[280px] items-center justify-center text-sm text-gray-500 sm:h-[380px] lg:h-[500px]">
                                No photo available
                            </div>

                        @endif

                    </div>

                    {{-- SHARE PET PROFILE --}}
                    <div class="mt-5 rounded-2xl border border-orange-100 bg-orange-50/60 p-4">

                        <p class="text-sm font-semibold text-gray-800">
                            Share This Pet
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Share this pet's profile with friends and family.
                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-3">

                            {{-- FACEBOOK --}}
                            <a
                                href="{{ $facebookShare }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-11 items-center justify-center rounded-full bg-blue-600 px-5 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700 hover:shadow-md"
                                title="Share on Facebook"
                            >
                                Facebook
                            </a>

                            {{-- WHATSAPP --}}
                            <a
                                href="{{ $whatsappShare }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-11 items-center justify-center rounded-full bg-green-600 px-5 text-sm font-semibold text-white transition duration-200 hover:bg-green-700 hover:shadow-md"
                                title="Share on WhatsApp"
                            >
                                WhatsApp
                            </a>

                            {{-- COPY LINK --}}
                            <button
                                type="button"
                                onclick="copyPetLink()"
                                class="flex h-11 items-center justify-center rounded-full border border-orange-300 bg-white px-5 text-sm font-semibold text-orange-600 transition duration-200 hover:bg-orange-100"
                                title="Copy Pet Link"
                            >
                                Copy Link
                            </button>

                        </div>

                        {{-- HIDDEN SHARE LINK --}}
                        <input
                            type="text"
                            id="pet-share-url"
                            value="{{ $petUrl }}"
                            readonly
                            class="sr-only"
                        >

                        <p
                            id="copy-message"
                            class="mt-3 text-sm text-green-600"
                            role="status"
                        ></p>

                    </div>

                </div>

                {{-- RIGHT SIDE --}}
                <div>

                    {{-- STATUS --}}
                    <span class="inline-block rounded-full border px-4 py-2 text-sm font-semibold
                        {{ in_array($pet->status, ['Available', 'Adopted'])
                            ? 'border-green-200 bg-green-50 text-green-700'
                            : 'border-red-200 bg-red-50 text-red-700' }}"
                    >
                        {{ $pet->status }}
                    </span>

                    {{-- PET NAME --}}
                    <h1 class="mt-4 text-4xl font-bold text-gray-900">
                        {{ $pet->name }}
                    </h1>

                    {{-- DESCRIPTION --}}
                    <p class="mt-4 text-lg leading-8 text-gray-600">
                        {{ $pet->description }}
                    </p>

                    {{-- BASIC INFORMATION --}}
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

                        <div class="rounded-xl border border-orange-100 bg-orange-50/70 p-4">

                            <p class="text-sm text-gray-500">
                                Pet Type
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $pet->type }}
                            </p>

                        </div>

                        <div class="rounded-xl border border-orange-100 bg-orange-50/70 p-4">

                            <p class="text-sm text-gray-500">
                                Sex
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $pet->sex }}
                            </p>

                        </div>

                        <div class="rounded-xl border border-orange-100 bg-orange-50/70 p-4">

                            <p class="text-sm text-gray-500">
                                Age
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $formattedAge }}
                            </p>

                        </div>

                    </div>

                    {{-- PET INTAKE DETAILS --}}
                    <div class="mt-8 overflow-hidden rounded-2xl border border-orange-100 bg-white">

                        <div class="border-b border-orange-100 bg-orange-50/70 px-5 py-4">

                            <h2 class="text-xl font-bold text-gray-900">
                                Pet Intake Details
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Information about the pet's arrival at the shelter
                            </p>

                        </div>

                        <div class="space-y-4 px-5 py-4">

                            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-orange-100 pb-3">

                                <p class="text-sm text-gray-500">
                                    Pet Origin
                                </p>

                                <p class="font-semibold text-gray-900">
                                    {{ $pet->intake_type ?: 'Not recorded' }}
                                </p>

                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3">

                                <p class="text-sm text-gray-500">
                                    Date Rescued / Surrendered
                                </p>

                                <p class="font-semibold text-gray-900">
                                    {{ $pet->intake_date?->format('M d, Y') ?? 'Not recorded' }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- VACCINATION DETAILS --}}
                    <div class="mt-6 overflow-hidden rounded-2xl border border-orange-100 bg-white">

                        <div class="border-b border-orange-100 bg-orange-50/70 px-5 py-4">

                            <h2 class="text-xl font-bold text-gray-900">
                                Vaccination Details
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Available vaccination records for this pet
                            </p>

                        </div>

                        <div class="space-y-4 px-5 py-4">

                            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-orange-100 pb-3">

                                <p class="text-sm text-gray-500">
                                    Vaccination Type
                                </p>

                                <p class="font-semibold text-gray-900">
                                    {{ $pet->vaccination_type ?: 'Not recorded' }}
                                </p>

                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3">

                                <p class="text-sm text-gray-500">
                                    Vaccination Date
                                </p>

                                <p class="font-semibold text-gray-900">
                                    {{ $pet->vaccination_date?->format('M d, Y') ?? 'Not recorded' }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- ADOPTION ACTION --}}
                    <div class="mt-8 border-t border-orange-100 pt-6">

                        @if ($pet->status === 'Available')

                            @guest

                                <a
                                    href="{{ route('login', ['pet' => $pet->id]) }}"
                                    class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                                >
                                    Log In to Apply
                                </a>

                            @else

                                @if (auth()->user()->role === 'adopter')

                                    @if ($profile)

                                        @if ($existingApplication)

                                            @if (! $existingApplication->compatibilityAssessment)

                                                <a
                                                    href="{{ route('compatibility-assessments.create', $existingApplication) }}"
                                                    class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                                                >
                                                    Continue Compatibility Assessment
                                                </a>

                                            @else

                                                <a
                                                    href="{{ route('adoption-applications.index') }}"
                                                    class="inline-block rounded-full border px-8 py-3 font-semibold transition duration-200
                                                        @if ($existingApplication->status === 'Approved')
                                                            border-green-200 bg-green-50 text-green-700 hover:bg-green-100
                                                        @elseif ($existingApplication->status === 'Rejected')
                                                            border-red-200 bg-red-50 text-red-700 hover:bg-red-100
                                                        @else
                                                            border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100
                                                        @endif"
                                                >
                                                    Already Applied ({{ $existingApplication->status }})
                                                </a>

                                            @endif

                                        @else

                                            <a
                                                href="{{ route('adoption-applications.create', $pet) }}"
                                                class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                                            >
                                                Apply for Adoption
                                            </a>

                                        @endif

                                    @else

                                        <a
                                            href="{{ route('profile.edit') }}"
                                            class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                                        >
                                            Complete Profile to Apply
                                        </a>

                                    @endif

                                @endif

                            @endguest

                        @elseif ($pet->status === 'Adopted')

                            <p class="inline-block rounded-xl border border-green-200 bg-green-50 px-5 py-3 font-semibold text-green-700">
                                This pet has already been adopted.
                            </p>

                        @else

                            <p class="inline-block rounded-xl border border-gray-200 bg-gray-50 px-5 py-3 font-semibold text-gray-600">
                                This pet is currently not available for adoption.
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<script>
    async function copyPetLink() {
        const input = document.getElementById('pet-share-url');
        const message = document.getElementById('copy-message');

        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(input.value);
            } else {
                const tempInput = document.createElement('input');
                tempInput.value = input.value;
                document.body.appendChild(tempInput);
                tempInput.select();

                const copied = document.execCommand('copy');
                document.body.removeChild(tempInput);

                if (!copied) {
                    message.textContent = 'Please copy the link manually.';
                    return;
                }
            }

            message.textContent = 'Pet link copied successfully!';
        } catch (error) {
            message.textContent = 'Please copy the link manually.';
        }
    }
</script>

@endsection