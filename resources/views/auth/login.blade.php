@extends('layouts.app')

@section('title', 'Login - Pawfect Match')


@section('content')

<section class="bg-orange-50 py-16">

    <div class="mx-auto max-w-md px-6">

        <div class="rounded-3xl bg-white p-6 shadow-sm sm:p-10">

            <div class="text-center">

                <div class="text-5xl">
                    🐾
                </div>

                <h1 class="mt-4 text-3xl font-bold text-gray-900">
                    Welcome Back
                </h1>

                <p class="mt-3 text-gray-600">
                    Log in to continue your Pawfect Match journey.
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


            <form action="{{ url('/login') }}"
                  method="POST"
                  class="mt-8 space-y-6">

                @csrf


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
                           autofocus
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
                           autocomplete="current-password"
                           class="mt-2 w-full rounded-xl
                                  border border-gray-300
                                  px-4 py-3
                                  focus:border-orange-500
                                  focus:outline-none">

                </div>


                <label class="flex items-center gap-2
                              text-sm text-gray-600">

                    <input type="checkbox"
                           name="remember"
                           class="rounded border-gray-300">

                    Remember me

                </label>


                <button type="submit"
                        class="w-full rounded-full
                               bg-orange-500 px-6 py-3
                               font-semibold text-white
                               hover:bg-orange-600">

                    Login

                </button>

            </form>


            <p class="mt-8 text-center text-sm text-gray-600">

                Don't have an account?

                <a href="{{ route('register') }}"
                   class="font-semibold text-orange-500
                          hover:text-orange-600">

                    Create an account

                </a>

            </p>

        </div>

    </div>

</section>

@endsection