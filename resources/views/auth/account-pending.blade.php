@extends('layouts.app')

@section('title', 'Account Verification - Pawfect Match')

@section('content')

<section class="flex min-h-[70vh] items-center justify-center bg-orange-50/40 px-4 py-12">

    <div class="w-full max-w-lg">

        {{-- PAGE HEADER --}}
        <div class="relative overflow-hidden rounded-3xl border border-orange-200 bg-orange-100 p-6 text-center sm:p-8">

            <div class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full border-[18px] border-orange-200/60"></div>

            <div class="relative">

                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Bayambang Animal Shelter
                </p>

                <h1 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                    Account Verification
                </h1>

                <div class="mx-auto mt-4 h-1 w-12 rounded-full bg-orange-400"></div>

                <p class="mt-4 text-sm leading-6 text-gray-600">
                    Stay updated on the verification status of your PAWFECT account.
                </p>

            </div>

        </div>

        {{-- VERIFICATION CONTENT --}}
        <div class="mt-6 rounded-3xl border border-orange-100 bg-white p-6 text-center shadow-sm sm:p-8">

            @if (session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>

            @endif

            @if (auth()->user()->approval_status === 'Rejected')

                {{-- REJECTED STATUS --}}
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100">

                    <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path stroke-linecap="round" d="M9 9l6 6M15 9l-6 6"></path>
                    </svg>

                </div>

                <h2 class="mt-5 text-2xl font-bold text-gray-900">
                    Account Verification Rejected
                </h2>

                <p class="mt-3 text-sm leading-7 text-gray-600">
                    Your account registration was not approved by
                    Bayambang Animal Shelter.
                </p>

                {{-- REJECTION REASON --}}
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-left">

                    <h3 class="font-bold text-red-700">
                        Reason for Rejection
                    </h3>

                    <p class="mt-3 whitespace-pre-line break-words text-sm leading-7 text-red-700">{{ auth()->user()->rejection_reason ?: 'No rejection reason was recorded for this account. Please contact the shelter for clarification.' }}</p>

                </div>

                {{-- RESUBMISSION FORM --}}
                <div class="mt-6 border-t border-orange-100 pt-6 text-left">

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Account Verification
                    </p>

                    <h3 class="mt-1 text-lg font-bold text-gray-900">
                        Resubmit Your Valid ID
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        You can submit a new valid ID for verification.
                        Make sure the image is clear and all important
                        information is readable.
                    </p>

                    <form
                        action="{{ route('account.resubmit') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-5"
                    >
                        @csrf

                        <label
                            for="valid_id"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Upload New Valid ID
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="file"
                            id="valid_id"
                            name="valid_id"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                            class="mt-3 block w-full rounded-xl border border-gray-300 bg-white p-3 text-sm text-gray-700 transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100 file:mr-3 file:rounded-full file:border-0 file:bg-orange-100 file:px-4 file:py-2 file:font-semibold file:text-orange-600 hover:file:bg-orange-200"
                        >

                        <p class="mt-2 text-xs text-gray-500">
                            Accepted formats: JPG, JPEG, PNG, and WebP.
                            Maximum file size: 5 MB.
                        </p>

                        @error('valid_id')
                            <p class="mt-3 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <button
                            type="submit"
                            class="mt-5 w-full rounded-full bg-orange-500 px-6 py-3 font-semibold text-white shadow-sm transition duration-200 hover:bg-orange-600 hover:shadow-md"
                        >
                            Resubmit for Verification
                        </button>

                    </form>

                </div>

            @else

                {{-- PENDING STATUS --}}
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-amber-100">

                    <svg class="h-7 w-7 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"></path>
                    </svg>

                </div>

                <h2 class="mt-5 text-2xl font-bold text-gray-900">
                    Account Pending Approval
                </h2>

                <p class="mt-3 text-sm leading-7 text-gray-600">
                    Your registration and valid ID have been submitted.
                    Your account is waiting for verification by
                    Bayambang Animal Shelter.
                </p>

                <div class="mt-6 rounded-2xl border border-orange-200 bg-orange-50 p-5">

                    <p class="text-sm leading-7 text-orange-800">
                        You will be able to access the adoption features
                        once an administrator approves your account.
                    </p>

                </div>

            @endif

            {{-- ACCOUNT EMAIL --}}
            <div class="mt-6 border-t border-orange-100 pt-5">

                <p class="text-sm text-gray-500">
                    Registered Account
                </p>

                <p class="mt-2 break-words font-semibold text-gray-900">
                    {{ auth()->user()->email }}
                </p>

            </div>

            {{-- LOGOUT --}}
            <form
                action="{{ url('/logout') }}"
                method="POST"
                class="mt-6"
            >
                @csrf

                <button
                    type="submit"
                    class="rounded-full border border-orange-200 bg-orange-50 px-8 py-3 font-semibold text-orange-600 transition duration-200 hover:border-orange-300 hover:bg-orange-100"
                >
                    Logout
                </button>

            </form>

        </div>

    </div>

</section>

@endsection