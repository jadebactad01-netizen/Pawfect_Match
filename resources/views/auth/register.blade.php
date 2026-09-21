@extends('layouts.app')

@section('title', 'Register - Pawfect Match')


@section('content')

<section class="bg-orange-50 py-16">

    <div class="mx-auto max-w-lg px-6">

        <div class="rounded-3xl bg-white p-6 shadow-sm sm:p-10">

            <div class="text-center">

                <div class="text-5xl">
                    🐾
                </div>

                <h1 class="mt-4 text-3xl font-bold text-gray-900">
                    Create Your Account
                </h1>

                <p class="mt-3 text-gray-600">
                    Join Pawfect Match and find a pet
                    that fits your lifestyle.
                </p>

            </div>


            @if ($errors->any())

                <div class="mt-6 rounded-2xl bg-red-50
                            p-4 text-sm text-red-700">

                    <ul class="list-disc pl-5">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ url('/register') }}"
                  method="POST"
                  class="mt-8 space-y-6">

                @csrf


                <div>

                    <label for="name"
                           class="font-semibold text-gray-700">
                        Full Name
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3
                                  focus:border-orange-500
                                  focus:outline-none">

                </div>


                <div>

                    <label for="email"
                           class="font-semibold text-gray-700">
                        Email Address
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3
                                  focus:border-orange-500
                                  focus:outline-none">

                </div>


                <div>

                    <label for="password"
                           class="font-semibold text-gray-700">
                        Password
                    </label>

                    <input type="password"
                           id="password"
                           name="password"
                           required
                           autocomplete="new-password"
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3
                                  focus:border-orange-500
                                  focus:outline-none">

                </div>


                <div>

                    <label for="password_confirmation"
                           class="font-semibold text-gray-700">
                        Confirm Password
                    </label>

                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3
                                  focus:border-orange-500
                                  focus:outline-none">

                </div>


                <button type="submit"
                        class="w-full rounded-full
                               bg-orange-500 px-6 py-3
                               font-semibold text-white
                               hover:bg-orange-600">

                    Create Account

                </button>

            </form>


            <p class="mt-8 text-center text-sm text-gray-600">

                Already have an account?

                <a href="{{ route('login') }}"
                   class="font-semibold text-orange-500
                          hover:text-orange-600">

                    Login

                </a>

            </p>

        </div>

    </div>

</section>

@endsection