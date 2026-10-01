@extends('layouts.app')

@section('title', 'Edit Administrator')

@section('content')

<section class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-2xl px-6">

        <a
            href="{{ route(
                'super-admin.administrators.index'
            ) }}"
            class="font-semibold text-orange-500
                   hover:text-orange-600"
        >
            ← Back to Administrators
        </a>


        <div class="mt-6 rounded-3xl bg-white
                    p-6 shadow-sm sm:p-8">

            <h1 class="text-2xl font-bold text-gray-900">
                Edit Administrator
            </h1>

            <p class="mt-2 text-gray-600">
                Update the administrator's account information.
            </p>


            <form
                action="{{ route(
                    'super-admin.administrators.update',
                    $administrator
                ) }}"
                method="POST"
                class="mt-8 space-y-6"
            >

                @csrf
                @method('PUT')


                <div>

                    <label
                        for="name"
                        class="font-semibold text-gray-700"
                    >
                        Name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old(
                            'name',
                            $administrator->name
                        ) }}"
                        required
                        class="mt-2 w-full rounded-xl
                               border border-gray-300
                               px-4 py-3"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label
                        for="email"
                        class="font-semibold text-gray-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old(
                            'email',
                            $administrator->email
                        ) }}"
                        required
                        class="mt-2 w-full rounded-xl
                               border border-gray-300
                               px-4 py-3"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <button
                    type="submit"
                    class="rounded-full bg-orange-500
                           px-6 py-3 font-semibold text-white
                           hover:bg-orange-600"
                >
                    Save Changes
                </button>

            </form>

        </div>

    </div>

</section>

@endsection