<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- Makes the website responsive on phones and tablets -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Pawfect Match')</title>

    <!-- Loads our Tailwind CSS and JavaScript through Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-orange-50 text-gray-800">

<!-- =========================
     NAVIGATION BAR
========================== -->

<header class="bg-white shadow-sm">

    <nav class="mx-auto flex max-w-7xl items-center
                justify-between px-6 py-4">

        <!-- Website Logo / Name -->
        <a href="{{ route('home') }}"
           class="flex items-center gap-3 text-xl
                  font-bold text-orange-500">

            <img
                src="{{ asset('images/pawfect-logo.png') }}"
                alt="Pawfect Match Logo"
                class="h-11 w-11 rounded-full object-cover"
            >

            <span>Pawfect Match</span>

        </a>


        <!-- =========================================
             DESKTOP NAVIGATION
        ========================================== -->

        <div class="hidden items-center gap-3 lg:flex">


            <!-- GUEST + ADOPTER LINKS -->
            @if (! auth()->check() || auth()->user()->role === 'adopter')


                <!-- Home -->
                <a
                    href="{{ route('home') }}"
                    class="rounded-lg px-3 py-2 font-medium
                        {{
                            request()->routeIs('home')
                            && ! request()->has('public')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Home
                </a>


                <!-- Available Pets -->
                <a
                    href="{{ route('pets.index') }}"
                    class="rounded-lg px-3 py-2 font-medium
                        {{
                            request()->routeIs('pets.*')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Available Pets
                </a>


                <!-- How It Works -->
                <a
                    href="{{
                        auth()->check()
                        && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#how-it-works'
                            : route('home') . '#how-it-works'
                    }}"
                    class="rounded-lg px-3 py-2 font-medium
                           text-gray-600
                           hover:bg-orange-50
                           hover:text-orange-500"
                >
                    How It Works
                </a>


                <!-- About Us -->
                <a
                    href="{{
                        auth()->check()
                        && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#about'
                            : route('home') . '#about'
                    }}"
                    class="rounded-lg px-3 py-2 font-medium
                           text-gray-600
                           hover:bg-orange-50
                           hover:text-orange-500"
                >
                    About Us
                </a>

            @endif


            <!-- =========================================
                 GUEST ACCOUNT LINKS
            ========================================== -->

            @guest

                <a
                    href="{{ route('login') }}"
                    class="rounded-lg px-3 py-2 font-semibold
                        {{
                            request()->routeIs('login')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-700 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Login
                </a>


                <a
                    href="{{ route('register') }}"
                    class="rounded-full px-5 py-2 font-semibold
                        {{
                            request()->routeIs('register')
                                ? 'bg-orange-600 text-white'
                                : 'bg-orange-500 text-white hover:bg-orange-600'
                        }}"
                >
                    Register
                </a>

            @endguest


            <!-- =========================================
                 LOGGED-IN USER LINKS
            ========================================== -->

            @auth


                <!-- ADOPTER -->
                @if (auth()->user()->role === 'adopter')

                    <a
                        href="{{ route('adoption-applications.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('adoption-applications.*')
                                || request()->routeIs('compatibility-assessments.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        My Applications
                    </a>

                @endif


                <!-- ADMIN + SUPER ADMIN -->
                @if (in_array(
                    auth()->user()->role,
                    ['admin', 'super_admin']
                ))

                    <a
                        href="{{ route('admin.pets.manage') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.pets.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Manage Pets
                    </a>


                    <a
                        href="{{ route('admin.adopters.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.adopters.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Adopters
                    </a>


                    <a
                        href="{{ route('admin.applications.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.applications.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Applications
                    </a>


                    <a
                        href="{{ route('admin.adoption-records.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.adoption-records.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Adoption Records
                    </a>

                @endif


                <!-- SUPER ADMIN ONLY -->
                @if (auth()->user()->role === 'super_admin')

                    <a
                        href="{{ route(
                            'super-admin.administrators.index'
                        ) }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs(
                                    'super-admin.administrators.*'
                                )
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Administrators
                    </a>

                @endif


                <!-- PROFILE -->
                <a
                    href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 rounded-full
                           border border-orange-200 px-4 py-2
                           font-semibold
                        {{
                            request()->routeIs('profile.*')
                                ? 'bg-orange-500 text-white'
                                : 'bg-orange-50 text-orange-600 hover:bg-orange-100'
                        }}"
                >
                    <span>👤</span>

                    <span>
                        {{ auth()->user()->name }}
                    </span>
                </a>


                <!-- LOGOUT -->
                <form
                    action="{{ url('/logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg px-3 py-2
                               font-semibold text-red-500
                               hover:bg-red-50 hover:text-red-600"
                    >
                        Logout
                    </button>

                </form>

            @endauth

        </div>


        <!-- =========================================
             MOBILE MENU BUTTON
        ========================================== -->

        <button
            id="menu-button"
            class="text-2xl lg:hidden"
            aria-label="Open menu"
        >
            ☰
        </button>

    </nav>


    <!-- =========================================
         MOBILE NAVIGATION
    ========================================== -->

    <div
        id="mobile-menu"
        class="hidden border-t bg-white px-6 pb-5 lg:hidden"
    >

        <div class="flex flex-col gap-2 pt-4">


            <!-- GUEST + ADOPTER LINKS -->
            @if (! auth()->check() || auth()->user()->role === 'adopter')


                <!-- Home -->
                <a
                    href="{{ route('home') }}"
                    class="rounded-lg px-3 py-2 font-medium
                        {{
                            request()->routeIs('home')
                            && ! request()->has('public')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Home
                </a>


                <!-- Available Pets -->
                <a
                    href="{{ route('pets.index') }}"
                    class="rounded-lg px-3 py-2 font-medium
                        {{
                            request()->routeIs('pets.*')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Available Pets
                </a>


                <!-- How It Works -->
                <a
                    href="{{
                        auth()->check()
                        && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#how-it-works'
                            : route('home') . '#how-it-works'
                    }}"
                    class="rounded-lg px-3 py-2 font-medium
                           text-gray-600
                           hover:bg-orange-50
                           hover:text-orange-500"
                >
                    How It Works
                </a>


                <!-- About Us -->
                <a
                    href="{{
                        auth()->check()
                        && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#about'
                            : route('home') . '#about'
                    }}"
                    class="rounded-lg px-3 py-2 font-medium
                           text-gray-600
                           hover:bg-orange-50
                           hover:text-orange-500"
                >
                    About Us
                </a>

            @endif


            <!-- GUEST -->
            @guest

                <a
                    href="{{ route('login') }}"
                    class="rounded-lg px-3 py-2 font-semibold
                        {{
                            request()->routeIs('login')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-700 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Login
                </a>


                <a
                    href="{{ route('register') }}"
                    class="rounded-lg px-3 py-2 font-semibold
                        {{
                            request()->routeIs('register')
                                ? 'bg-orange-500 text-white'
                                : 'text-orange-500 hover:bg-orange-50'
                        }}"
                >
                    Register
                </a>

            @endguest


            <!-- LOGGED-IN USERS -->
            @auth


                <!-- ADOPTER -->
                @if (auth()->user()->role === 'adopter')

                    <a
                        href="{{ route('adoption-applications.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('adoption-applications.*')
                                || request()->routeIs('compatibility-assessments.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        My Applications
                    </a>

                @endif


                <!-- ADMIN + SUPER ADMIN -->
                @if (in_array(
                    auth()->user()->role,
                    ['admin', 'super_admin']
                ))

                    @if (
                    request()->routeIs('admin.pets.manage')
                    || request()->routeIs('admin.adopters.index')
                    || request()->routeIs('admin.applications.index')
                    || request()->routeIs('admin.adoption-records.index')
                )

                    <form
                        action="{{ url()->current() }}"
                        method="GET"
                        class="flex items-center"
                    >

                        @if (
                            request()->routeIs('admin.adoption-records.index')
                            && request('status')
                        )
                            <input
                                type="hidden"
                                name="status"
                                value="{{ request('status') }}"
                            >
                        @endif

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search..."
                            class="w-40 rounded-l-lg border border-gray-300
                                px-3 py-2 text-sm outline-none
                                focus:border-orange-500"
                        >

                        <button
                            type="submit"
                            class="rounded-r-lg bg-orange-500
                                px-3 py-2 text-sm font-semibold
                                text-white hover:bg-orange-600"
                        >
                            Search
                        </button>

                    </form>

                @endif

                    <a
                        href="{{ route('admin.pets.manage') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.pets.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Manage Pets
                    </a>


                    <a
                        href="{{ route('admin.adopters.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.adopters.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Adopters
                    </a>


                    <a
                        href="{{ route('admin.applications.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.applications.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Applications
                    </a>


                    <a
                        href="{{ route('admin.adoption-records.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.adoption-records.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Adoption Records
                    </a>

                @endif


                <!-- SUPER ADMIN -->
                @if (auth()->user()->role === 'super_admin')

                    <a
                        href="{{ route(
                            'super-admin.administrators.index'
                        ) }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs(
                                    'super-admin.administrators.*'
                                )
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Administrators
                    </a>

                @endif


                <!-- PROFILE -->
                <a
                    href="{{ route('profile.edit') }}"
                    class="mt-2 flex items-center gap-2
                           rounded-xl border border-orange-200
                           px-4 py-3 font-semibold
                        {{
                            request()->routeIs('profile.*')
                                ? 'bg-orange-500 text-white'
                                : 'bg-orange-50 text-orange-600'
                        }}"
                >
                    <span>👤</span>

                    <span>
                        {{ auth()->user()->name }}
                    </span>
                </a>


                <!-- LOGOUT -->
                <form
                    action="{{ url('/logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg px-3 py-2
                               text-left font-semibold text-red-500
                               hover:bg-red-50"
                    >
                        Logout
                    </button>

                </form>

            @endauth

        </div>

    </div>

</header>


<!-- =========================
     FLASH MESSAGES
========================== -->

@if (session('success'))

    <div class="mx-auto mt-4 max-w-7xl px-6">

        <div class="rounded-xl border border-green-200
                    bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>

    </div>

@endif


@if (session('error'))

    <div class="mx-auto mt-4 max-w-7xl px-6">

        <div class="rounded-xl border border-red-200
                    bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>

    </div>

@endif


<!-- =========================
     PAGE CONTENT
========================== -->

<main>
    @yield('content')
</main>


    <!-- =========================
         FOOTER
    ========================== -->

    <footer class="bg-gray-900 text-gray-300">

        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-12
                    md:grid-cols-3">

            <!-- Pawfect Match -->
            <div>

                <h3 class="mb-4 flex items-center gap-2
                           text-xl font-bold text-white">
                           
                    Pawfect Match

                </h3>

                <p class="leading-7 text-gray-400">
                    Helping adopters find pets that better match
                    their lifestyle and home environment.
                </p>

            </div>


            <!-- Quick Links -->
            <div>

                <h3 class="mb-4 font-semibold text-white">
                    Quick Links
                </h3>

                <div class="flex flex-col gap-3">

                    <a
                        href="{{ route('home') }}"
                        class="hover:text-orange-400"
                    >
                        Home
                    </a>

                    <a
                        href="{{ route('pets.index') }}"
                        class="hover:text-orange-400"
                    >
                        Available Pets
                    </a>

                    <a
                        href="{{
                            auth()->check()
                            && auth()->user()->role === 'adopter'
                                ? route('home', ['public' => 1]) . '#how-it-works'
                                : route('home') . '#how-it-works'
                        }}"
                        class="hover:text-orange-400"
                    >
                        How It Works
                    </a>

                    <a
                        href="{{
                            auth()->check()
                            && auth()->user()->role === 'adopter'
                                ? route('home', ['public' => 1]) . '#about'
                                : route('home') . '#about'
                        }}"
                        class="hover:text-orange-400"
                    >
                        About Us
                    </a>

                </div>

            </div>


            <!-- Shelter -->
            <div>

                <h3 class="mb-4 font-semibold text-white">
                    Bayambang Animal Shelter
                </h3>

                <p class="leading-7 text-gray-400">
                    Bayambang, Pangasinan
                </p>

                <p class="mt-2 text-gray-400">
                    Give a pet a second chance at a loving home.
                </p>

            </div>

        </div>


        <div class="border-t border-gray-800 px-6 py-5 text-center
                    text-sm text-gray-500">

            © {{ date('Y') }} Pawfect Match.
            All rights reserved.

        </div>

    </footer>


    <!-- =========================
         SIMPLE MOBILE MENU SCRIPT
    ========================== -->

    <script>
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>