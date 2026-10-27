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
@endphp

<section class="min-h-screen bg-orange-50 py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">

        {{-- BACK BUTTON --}}
        <a
            href="{{ route('pets.index') }}"
            class="inline-flex items-center gap-2 font-semibold text-orange-500 hover:text-orange-600"
        >
            ← Back to Available Pets
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

        <div class="mt-8 rounded-3xl bg-white p-4 shadow-sm sm:p-6">
            <div class="grid gap-8 lg:grid-cols-2">

                {{-- LEFT SIDE --}}
                <div class="lg:pt-6">

                    {{-- PET IMAGE --}}
                    <div class="overflow-hidden rounded-2xl bg-orange-100">
                        @if ($pet->photo)
                            <img
                                src="{{ asset('storage/' . $pet->photo) }}"
                                alt="{{ $pet->name }}"
                                class="h-[80px] w-full object-cover object-center sm:h-[380px] lg:h-[500px]"
                            >
                        @else
                            <div class="flex h-[280px] items-center justify-center text-gray-400 sm:h-[380px] lg:h-[500px]">
                                No photo available
                            </div>
                        @endif
                    </div>

                    {{-- SHARE BUTTONS --}}
                    <div class="mt-5 flex flex-wrap items-center gap-4">

                        <a
                            href="{{ $facebookShare }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-2xl font-bold text-white hover:bg-blue-700"
                            title="Share on Facebook"
                        >
                            f
                        </a>

                        <a
                            href="{{ $whatsappShare }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-green-600 text-lg font-bold text-white hover:bg-green-700"
                            title="Share on WhatsApp"
                        >
                            W
                        </a>

                        <button
                            type="button"
                            onclick="copyPetLink()"
                            class="flex h-14 w-14 items-center justify-center rounded-full border-4 border-black bg-white text-2xl hover:bg-gray-100"
                            title="Copy Pet Link"
                        >
                            🔗
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

                {{-- RIGHT SIDE --}}
                <div>

                    {{-- STATUS --}}
                    <span class="inline-block rounded-full px-4 py-2 text-sm font-semibold
                        {{ $pet->status === 'Available'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ $pet->status }}
                    </span>

                    {{-- NAME --}}
                    <h1 class="mt-4 text-4xl font-bold text-gray-900">
                        {{ $pet->name }}
                    </h1>

                    {{-- DESCRIPTION --}}
                    <p class="mt-2 text-lg text-gray-600">
                        {{ $pet->description }}
                    </p>

                    {{-- BASIC INFO --}}
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

                        <div class="rounded-xl bg-orange-50 p-4">
                            <p class="text-sm text-gray-500">Pet Type</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $pet->type }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-orange-50 p-4">
                            <p class="text-sm text-gray-500">Sex</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $pet->sex }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-orange-50 p-4">
                            <p class="text-sm text-gray-500">Age</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $pet->age }}
                            </p>
                        </div>

                    </div>

                    {{-- PET INTAKE DETAILS --}}
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Pet Intake Details
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Information about the pet's arrival at the shelter
                        </p>

                        <div class="mt-4 space-y-4">

                            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-500">Pet Origin</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $pet->intake_type ?: 'Not recorded' }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
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
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Vaccination Details
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Available vaccination records for this pet
                        </p>

                        <div class="mt-4 space-y-4">

                            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-500">Vaccination Type</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $pet->vaccination_type ?: 'Not recorded' }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                                <p class="text-sm text-gray-500">Vaccination Date</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $pet->vaccination_date?->format('M d, Y') ?? 'Not recorded' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- APPLY BUTTON --}}
                    <div class="mt-8">

                        @if ($pet->status === 'Available')

                            @guest

                                <a
                                    href="{{ route('login', ['pet' => $pet->id]) }}"
                                    class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white hover:bg-orange-600"
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
                                                    class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white hover:bg-orange-600"
                                                >
                                                    Continue Compatibility Assessment
                                                </a>

                                            @else

                                                <a
                                                    href="{{ route('adoption-applications.index') }}"
                                                    class="inline-block rounded-full px-8 py-3 font-semibold
                                                        @if ($existingApplication->status === 'Approved')
                                                            bg-green-100 text-green-700 hover:bg-green-200
                                                        @elseif ($existingApplication->status === 'Rejected')
                                                            bg-red-100 text-red-700 hover:bg-red-200
                                                        @else
                                                            bg-yellow-100 text-yellow-700 hover:bg-yellow-200
                                                        @endif"
                                                >
                                                    Already Applied ({{ $existingApplication->status }})
                                                </a>

                                            @endif

                                        @else

                                            <a
                                                href="{{ route('adoption-applications.create', $pet) }}"
                                                class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white hover:bg-orange-600"
                                            >
                                                Apply for Adoption
                                            </a>

                                        @endif

                                    @else

                                        <a
                                            href="{{ route('profile.edit') }}"
                                            class="inline-block rounded-full bg-orange-500 px-8 py-3 font-semibold text-white hover:bg-orange-600"
                                        >
                                            Complete Profile to Apply
                                        </a>

                                    @endif

                                @endif

                            @endguest

                        @else

                            <p class="inline-block rounded-xl bg-gray-100 px-5 py-3 font-semibold text-gray-600">
                                This pet is currently not available for adoption.
                            </p>

                        @endif

                        <p class="mt-4 text-sm text-gray-500">
                            An approved adopter account is required to submit an adoption application.
                        </p>

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