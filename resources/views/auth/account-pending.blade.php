@extends('layouts.app')

@section('title', 'Account Verification - Pawfect Match')

@section('content')

<section class="flex min-h-[70vh] items-center justify-center bg-orange-50 px-4 py-12">

    <div class="w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-sm">

        @if (session('success'))
            <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (auth()->user()->approval_status === 'Rejected')

            <div class="text-5xl">❌</div>

            <h1 class="mt-5 text-2xl font-bold text-gray-900">
                Account Verification Rejected
            </h1>

            <p class="mt-4 leading-7 text-gray-600">
                Your account registration was not approved by
                Bayambang Animal Shelter.
            </p>

            {{-- REJECTION REASON --}}
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-left">

                <h2 class="font-bold text-red-700">
                    Reason for Rejection
                </h2>

                <p class="mt-3 whitespace-pre-line break-words leading-7 text-red-700">{{ auth()->user()->rejection_reason ?: 'No rejection reason was recorded for this account. Please contact the shelter for clarification.' }}</p>

            </div>

            {{-- RESUBMISSION FORM --}}
            <div class="mt-6 border-t border-gray-100 pt-6 text-left">

                <h2 class="text-lg font-bold text-gray-900">
                    Resubmit Your Valid ID
                </h2>

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
                        class="mt-3 block w-full rounded-xl border border-gray-300 bg-white p-3 text-sm text-gray-700 file:mr-3 file:rounded-full file:border-0 file:bg-orange-100 file:px-4 file:py-2 file:font-semibold file:text-orange-600 hover:file:bg-orange-200"
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
                        class="mt-5 w-full rounded-full bg-orange-500 px-6 py-3 font-semibold text-white hover:bg-orange-600"
                    >
                        Resubmit for Verification
                    </button>

                </form>

            </div>

        @else

            <div class="text-5xl">⏳</div>

            <h1 class="mt-5 text-2xl font-bold text-gray-900">
                Account Pending Approval
            </h1>

            <p class="mt-4 leading-7 text-gray-600">
                Your registration and valid ID have been submitted.
                Your account is waiting for verification by
                Bayambang Animal Shelter.
            </p>

            <p class="mt-4 rounded-xl bg-orange-50 p-4 text-sm text-orange-800">
                You will be able to access the adoption features
                once an administrator approves your account.
            </p>

        @endif

        <p class="mt-6 break-words text-sm text-gray-500">
            Account:
            <span class="font-semibold">
                {{ auth()->user()->email }}
            </span>
        </p>

        <form
            action="{{ url('/logout') }}"
            method="POST"
            class="mt-8"
        >
            @csrf

            <button
                type="submit"
                class="rounded-full bg-orange-500 px-8 py-3 font-semibold text-white hover:bg-orange-600"
            >
                Logout
            </button>
        </form>

    </div>

</section>

@endsection