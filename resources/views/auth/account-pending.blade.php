@extends('layouts.app')

@section('title', 'Account Verification - Pawfect Match')

@section('content')

<section class="flex min-h-[70vh] items-center justify-center bg-orange-50 px-4 py-12">

    <div class="w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-sm">

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

            <p class="mt-5 text-sm leading-6 text-gray-600">
                If you have questions about this decision,
                please contact Bayambang Animal Shelter.
            </p>

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

        <p class="mt-6 text-sm text-gray-500">
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