@extends('layouts.app')

@section('title', 'Account Approvals - Pawfect Match')

@section('content')

<section class="min-h-screen bg-orange-50/40 py-10">

    <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6">

        {{-- PAGE HEADER --}}
        <div class="rounded-3xl border border-orange-200 bg-orange-100 p-6 sm:p-8">

            <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                Shelter Management
            </p>

            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                Adopter Account Approvals
            </h1>

            <p class="mt-2 text-sm leading-6 text-gray-600">
                Review adopter registrations, verify submitted IDs, and manage account approval decisions.
            </p>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>

        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700">

                <p class="font-semibold">
                    Please correct the following:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        {{-- ACCOUNT APPROVALS LIST --}}
        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm sm:p-6">

            {{-- SECTION HEADER --}}
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                        Account Verification
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                        Registration Reviews
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Pending and rejected adopter registrations.
                    </p>

                </div>

                <span class="rounded-full border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">
                    {{ $users->count() }}
                    {{ $users->count() === 1 ? 'Account' : 'Accounts' }}
                </span>

            </div>

            {{-- ACCOUNT LIST --}}
            @if ($users->isEmpty())

                <div class="rounded-xl border border-orange-100 bg-orange-50/50 p-6 text-center">

                    <p class="font-semibold text-gray-700">
                        No accounts waiting for review
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        There are no pending or rejected adopter registrations at the moment.
                    </p>

                </div>

            @else

                <div class="space-y-4">

                    @foreach ($users as $user)

                        <div class="rounded-xl border border-orange-100 bg-orange-50/30 p-5 sm:p-6">

                            {{-- ACCOUNT HEADER --}}
                            <div class="flex flex-wrap items-start justify-between gap-3 border-b border-orange-100 pb-4">

                                <div class="min-w-0">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-500">
                                        Adopter Registration
                                    </p>

                                    <h3 class="mt-1 break-words text-lg font-bold text-gray-900">
                                        {{ $user->name }}
                                    </h3>

                                    <p class="mt-1 break-all text-sm text-gray-600">
                                        {{ $user->email }}
                                    </p>

                                </div>

                                <span class="shrink-0 rounded-full border px-3 py-1 text-xs font-semibold
                                    @if ($user->approval_status === 'Pending')
                                        border-amber-200 bg-amber-50 text-amber-700
                                    @else
                                        border-red-200 bg-red-50 text-red-700
                                    @endif"
                                >
                                    {{ $user->approval_status }}
                                </span>

                            </div>

                            {{-- ACCOUNT DETAILS --}}
                            <div class="mt-5 grid gap-5 md:grid-cols-2">

                                {{-- APPLICANT DETAILS --}}
                                <div class="space-y-4">

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            Registration Date
                                        </p>

                                        <p class="mt-1 text-sm text-gray-800">
                                            {{ $user->created_at->format('F d, Y') }}
                                        </p>

                                    </div>

                                    {{-- REJECTION REASON --}}
                                    @if ($user->approval_status === 'Rejected')

                                        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                                            <p class="text-sm font-bold text-red-700">
                                                Reason for Rejection
                                            </p>

                                            <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-red-700">{{ $user->rejection_reason ?: 'No reason was recorded for this earlier rejection.' }}</p>

                                        </div>

                                    @endif

                                </div>

                                {{-- ID VERIFICATION AND REVIEW --}}
                                <div>

                                    <div class="rounded-xl border border-orange-100 bg-white p-4">

                                        <p class="text-sm font-semibold text-gray-900">
                                            Submitted Valid ID
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Open the submitted document to review the applicant's identity.
                                        </p>

                                        @if ($user->valid_id_path)

                                            <a
                                                href="{{ route('admin.account-approvals.id', $user) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-4 inline-flex items-center justify-center rounded-full border border-orange-300 bg-white px-5 py-2.5 text-sm font-semibold text-orange-600 transition hover:bg-orange-50"
                                            >
                                                View Submitted ID
                                            </a>

                                        @else

                                            <p class="mt-3 text-sm text-gray-500">
                                                No ID on file.
                                            </p>

                                        @endif

                                    </div>

                                    {{-- APPROVE AND REJECT FOR PENDING ACCOUNTS --}}
                                    @if ($user->approval_status === 'Pending')

                                        {{-- APPROVE REGISTRATION --}}
                                        <form
                                            action="{{ route('admin.account-approvals.review', $user) }}"
                                            method="POST"
                                            class="mt-4"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="decision"
                                                value="Approved"
                                            >

                                            <button
                                                type="submit"
                                                onclick="return confirm('Approve this adopter account?')"
                                                class="rounded-full bg-green-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700"
                                            >
                                                Approve Registration
                                            </button>

                                        </form>

                                        {{-- REJECT REGISTRATION --}}
                                        <form
                                            action="{{ route('admin.account-approvals.review', $user) }}"
                                            method="POST"
                                            class="mt-4 border-t border-orange-100 pt-4"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="decision"
                                                value="Rejected"
                                            >

                                            <input
                                                type="hidden"
                                                name="review_user_id"
                                                value="{{ $user->id }}"
                                            >

                                            <label
                                                for="rejection_reason_{{ $user->id }}"
                                                class="block text-sm font-semibold text-gray-700"
                                            >
                                                Reason for Rejection
                                                <span class="text-red-500">*</span>
                                            </label>

                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                Explain why the registration cannot be approved.
                                                The adopter will see this message.
                                            </p>

                                            <textarea
                                                id="rejection_reason_{{ $user->id }}"
                                                name="rejection_reason"
                                                rows="3"
                                                maxlength="1000"
                                                required
                                                placeholder="Example: The submitted valid ID is blurry and cannot be verified."
                                                class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                            >{{ old('review_user_id') == $user->id ? old('rejection_reason') : '' }}</textarea>

                                            <button
                                                type="submit"
                                                onclick="return confirm('Reject this adopter registration? The applicant will see the reason provided.')"
                                                class="mt-3 rounded-full border border-red-200 bg-white px-6 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                            >
                                                Reject Registration
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</section>

@endsection