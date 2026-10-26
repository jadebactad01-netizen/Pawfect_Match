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
                Your account registration was not approved by the shelter.
                Please contact Bayambang Animal Shelter if you need
                clarification or would like to ask about submitting
                a new valid ID.
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

        <p class="mt-5 text-sm text-gray-500">
            Account:
            <span class="font-semibold">
                {{ auth()->user()->email }}
            </span>
        </p>

        <form action="{{ url('/logout') }}"
              method="POST"
              class="mt-8">
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