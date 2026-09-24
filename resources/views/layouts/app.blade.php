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
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            <!-- Website Logo / Name -->
            <a href="{{ route('home') }}"
               class="flex items-center gap-2 text-xl font-bold text-orange-500">

                <span class="text-2xl">🐾</span>

                <span>Pawfect Match</span>
            </a>


            <!-- Desktop Navigation -->
            <div class="hidden items-center gap-8 md:flex">

                <a href="{{ route('home') }}"
                   class="font-medium text-orange-500">
                    Home
                </a>

                <a href="#pets"
                   class="font-medium text-gray-600 hover:text-orange-500">
                    Available Pets
                </a>

                <a href="#how-it-works"
                   class="font-medium text-gray-600 hover:text-orange-500">
                    How It Works
                </a>

                <a href="#about"
                   class="font-medium text-gray-600 hover:text-orange-500">
                    About Us
                </a>

                @guest

                    <a href="{{ route('login') }}"
                    class="font-semibold text-gray-700 hover:text-orange-500">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                    class="rounded-full bg-orange-500
                            px-5 py-2 font-semibold text-white
                            hover:bg-orange-600">
                        Register
                    </a>

                @endguest


                @auth

                    <span class="font-semibold text-gray-700">
                        {{ auth()->user()->name }}
                    </span>

                    @if (auth()->user()->role === 'adopter')
                        <a href="{{ route('profile.edit') }}"
                        class="font-semibold text-gray-700 hover:text-orange-500">
                            My Profile
                        </a>

                        <a href="{{ route('adoption-applications.index') }}"
                            class="hover:text-orange-500">
                            My Applications
                        </a>
                    @endif

                    

                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))

                        <a href="{{ route('admin.pets.manage') }}"
                        class="font-semibold text-orange-500">
                            Manage Pets
                        </a>

                        <a href="{{ route('admin.applications.index') }}"
                            class="font-semibold text-gray-700 hover:text-orange-500">
                            Applications
                        </a>

                    @endif

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="font-semibold text-red-500 hover:text-red-600">
                            Logout
                        </button>
                    </form>

                @endauth

            </div>


            <!-- Mobile Menu Button -->
            <button
                id="menu-button"
                class="text-2xl md:hidden"
                aria-label="Open menu">
                ☰
            </button>

        </nav>


        <!-- Mobile Navigation -->
        <div
            id="mobile-menu"
            class="hidden border-t bg-white px-6 pb-5 md:hidden">

            <div class="flex flex-col gap-4 pt-4">

                <a href="{{ route('home') }}"
                   class="font-medium text-orange-500">
                    Home
                </a>

                <a href="#pets"
                class="font-medium text-gray-600 hover:text-orange-500">
                    Available Pets
                </a>

                <a href="#how-it-works"
                   class="text-gray-600">
                    How It Works
                </a>

                <a href="#about"
                   class="text-gray-600">
                    About Us
                </a>

                @guest

                    <a href="{{ route('login') }}"
                    class="font-semibold text-gray-700 hover:text-orange-500">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                    class="rounded-full bg-orange-500
                            px-5 py-2 font-semibold text-white
                            hover:bg-orange-600">
                        Register
                    </a>

                @endguest


                @auth

                    <span class="font-semibold text-gray-700">
                        {{ auth()->user()->name }}
                    </span>

                    @if (auth()->user()->role === 'adopter')
                        <a href="{{ route('profile.edit') }}"
                        class="font-semibold text-gray-700 hover:text-orange-500">
                            My Profile
                        </a>

                        <a href="{{ route('adoption-applications.index') }}"
                            class="hover:text-orange-500">
                            My Applications
                        </a>
                    @endif

                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))

                        <a href="{{ route('admin.pets.manage') }}"
                        class="font-semibold text-orange-500">
                            Manage Pets
                        </a>

                        <a href="{{ route('admin.applications.index') }}"
                            class="font-semibold text-gray-700 hover:text-orange-500">
                            Applications
                        </a>
                    @endif

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="font-semibold text-red-500 hover:text-red-600">
                            Logout
                        </button>
                    </form>

                @endauth

            </div>

        </div>

    </header>


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

                    <span>🐾</span>
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

                    <a href="{{ route('home') }}"
                       class="hover:text-orange-400">
                        Home
                    </a>

                    <a href="{{ route('pets.index') }}"
                    class="font-medium text-gray-600 hover:text-orange-500">
                        Available Pets
                    </a>

                    <a href="#how-it-works"
                       class="hover:text-orange-400">
                        How It Works
                    </a>

                    <a href="#about"
                       class="hover:text-orange-400">
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