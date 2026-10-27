@extends('layouts.app')

@section('title', 'Account Approvals - Pawfect Match')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-6xl px-4 sm:px-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">

            <div>
                <p class="font-semibold text-orange-500">
                    Shelter Administration
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    Adopter Account Approvals
                </h1>

                <p class="mt-2 text-gray-600">
                    Review valid IDs submitted during registration.
                </p>
            </div>

        </div>

        {{-- NOTIFICATIONS --}}
        @if (session('success'))
            <div class="mt-6 rounded-xl bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-6 rounded-xl bg-red-50 p-4 text-red-700">
                <p class="font-semibold">
                    Please correct the following:
                </p>

                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ACCOUNT LIST --}}
        @if ($users->isEmpty())

            <div class="mt-8 rounded-2xl bg-white p-8 shadow-sm">
                <p class="text-gray-600">
                    There are no pending or rejected registrations.
                </p>
            </div>

        @else

            <div class="mt-8 space-y-5">

                @foreach ($users as $user)

                    <div class="rounded-2xl bg-white p-6 shadow-sm">

                        <div class="grid gap-6 md:grid-cols-2">

                            {{-- APPLICANT INFORMATION --}}
                            <div>

                                <p class="text-sm text-gray-500">
                                    Applicant Name
                                </p>

                                <h2 class="mt-1 text-xl font-bold text-gray-900">
                                    {{ $user->name }}
                                </h2>

                                <p class="mt-2 text-gray-600">
                                    {{ $user->email }}
                                </p>

                                <p class="mt-3 text-sm text-gray-500">
                                    Registered:
                                    {{ $user->created_at->format('M d, Y') }}
                                </p>

                                <span
                                    class="mt-4 inline-block rounded-full px-4 py-2 text-sm font-semibold
                                    {{ $user->approval_status === 'Pending'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-red-100 text-red-700' }}"
                                >
                                    {{ $user->approval_status }}
                                </span>

                                {{-- EXISTING REJECTION REASON --}}
                                @if ($user->approval_status === 'Rejected')

                                    <div class="mt-5 rounded-xl bg-red-50 p-4">

                                        <p class="text-sm font-bold text-red-700">
                                            Reason for Rejection
                                        </p>

                                        <p class="mt-2 whitespace-pre-line break-words text-sm text-red-700">{{ $user->rejection_reason ?: 'No reason was recorded for this earlier rejection.' }}</p>

                                    </div>

                                @endif

                            </div>

                            {{-- VALID ID AND REVIEW --}}
                            <div>

                                <h3 class="font-semibold text-gray-900">
                                    Submitted Valid ID
                                </h3>

                                @if ($user->valid_id_path)

                                    <a
                                        href="{{ route('admin.account-approvals.id', $user) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-3 inline-block rounded-full border border-orange-500 px-5 py-2 font-semibold text-orange-600 hover:bg-orange-50"
                                    >
                                        View Submitted ID
                                    </a>

                                @else

                                    <p class="mt-3 text-sm text-gray-500">
                                        No ID on file.
                                    </p>

                                @endif

                                @if ($user->approval_status === 'Pending')

                                    {{-- APPROVE BUTTON --}}
                                    <form
                                        action="{{ route('admin.account-approvals.review', $user) }}"
                                        method="POST"
                                        class="mt-6"
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
                                            class="rounded-full bg-green-600 px-6 py-2 font-semibold text-white hover:bg-green-700"
                                        >
                                            Approve Registration
                                        </button>

                                    </form>

                                    {{-- REJECTION FORM --}}
                                    <form
                                        action="{{ route('admin.account-approvals.review', $user) }}"
                                        method="POST"
                                        class="mt-6 border-t border-gray-100 pt-5"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="decision"
                                            value="Rejected"
                                        >

                                        <label
                                            for="rejection_reason_{{ $user->id }}"
                                            class="block text-sm font-semibold text-gray-700"
                                        >
                                            Reason for Rejection
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Explain why the registration cannot
                                            be approved. The adopter will see
                                            this message.
                                        </p>

                                        <textarea
                                            id="rejection_reason_{{ $user->id }}"
                                            name="rejection_reason"
                                            rows="3"
                                            maxlength="1000"
                                            required
                                            placeholder="Example: The submitted valid ID is blurry and cannot be verified."
                                            class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none"
                                        >{{ old('review_user_id') == $user->id ? old('rejection_reason') : '' }}</textarea>

                                        <input
                                            type="hidden"
                                            name="review_user_id"
                                            value="{{ $user->id }}"
                                        >

                                        <button
                                            type="submit"
                                            onclick="return confirm('Reject this adopter registration? The applicant will see the reason provided.')"
                                            class="mt-3 rounded-full bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700"
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

</section>

@endsection