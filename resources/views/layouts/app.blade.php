<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Pawfect Match')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-orange-50 text-gray-800">

{{-- NAVIGATION BAR --}}
<header class="bg-white shadow-sm">

    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-4 sm:px-6">

        {{-- LOGO --}}
        <a
            href="{{ route('home') }}"
            class="flex shrink-0 items-center gap-2 whitespace-nowrap text-xl font-bold text-orange-500 xl:text-lg 2xl:text-xl"
        >
            <img
                src="{{ asset('images/pawfect-logo.png') }}"
                alt="Pawfect Match Logo"
                class="h-11 w-11 shrink-0 rounded-full object-cover"
            >

            <span>Pawfect Match</span>
        </a>

        {{-- DESKTOP NAVIGATION --}}
        <div class="hidden min-w-0 flex-nowrap items-center justify-end gap-1 whitespace-nowrap text-xs xl:flex 2xl:gap-2 2xl:text-sm">

            {{-- GUEST AND ADOPTER LINKS --}}
            @if (! auth()->check() || auth()->user()->role === 'adopter')

                <a
                    href="{{ route('home') }}"
                    class="rounded-lg px-2 py-2 font-medium
                        {{
                            request()->routeIs('home') && ! request()->has('public')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Home
                </a>

                <a
                    href="{{ route('pets.index') }}"
                    class="rounded-lg px-2 py-2 font-medium
                        {{
                            request()->routeIs('pets.*')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Available Pets
                </a>

                <a
                    href="{{
                        auth()->check() && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#how-it-works'
                            : route('home') . '#how-it-works'
                    }}"
                    class="rounded-lg px-2 py-2 font-medium text-gray-600 hover:bg-orange-50 hover:text-orange-500"
                >
                    How It Works
                </a>

                <a
                    href="{{
                        auth()->check() && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#about'
                            : route('home') . '#about'
                    }}"
                    class="rounded-lg px-2 py-2 font-medium text-gray-600 hover:bg-orange-50 hover:text-orange-500"
                >
                    About Us
                </a>

            @endif

            {{-- GUEST ACCOUNT LINKS --}}
            @guest

                <a
                    href="{{ route('login') }}"
                    class="rounded-lg px-2 py-2 font-semibold
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
                    class="rounded-full px-4 py-2 font-semibold
                        {{
                            request()->routeIs('register')
                                ? 'bg-orange-600 text-white'
                                : 'bg-orange-500 text-white hover:bg-orange-600'
                        }}"
                >
                    Register
                </a>

            @endguest

            {{-- LOGGED-IN USERS --}}
            @auth

                {{-- ADOPTER --}}
                @if (auth()->user()->role === 'adopter')

                    <a
                        href="{{ route('adoption-applications.index') }}"
                        class="rounded-lg px-2 py-2 font-medium
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

                {{-- ADMIN AND SUPER ADMIN --}}
                @if (in_array(auth()->user()->role, ['admin', 'super_admin']))

                    <a
                        href="{{ route('admin.pets.manage') }}"
                        class="rounded-lg px-2 py-2 font-medium
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
                        class="rounded-lg px-2 py-2 font-medium
                            {{
                                request()->routeIs('admin.adopters.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Adopters
                    </a>

                    <a
                        href="{{ route('admin.account-approvals.index') }}"
                        class="rounded-lg px-2 py-2 font-medium
                            {{
                                request()->routeIs('admin.account-approvals.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Account Approvals
                    </a>

                    <a
                        href="{{ route('admin.applications.index') }}"
                        class="rounded-lg px-2 py-2 font-medium
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
                        class="rounded-lg px-2 py-2 font-medium
                            {{
                                request()->routeIs('admin.adoption-records.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Adoption Records
                    </a>

                    {{-- NEW REPORTS LINK --}}
                    <a
                        href="{{ route('admin.reports.index') }}"
                        class="rounded-lg px-2 py-2 font-medium
                            {{
                                request()->routeIs('admin.reports.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Reports
                    </a>

                @endif

                {{-- SUPER ADMIN --}}
                @if (auth()->user()->role === 'super_admin')

                    <a
                        href="{{ route('super-admin.administrators.index') }}"
                        class="rounded-lg px-2 py-2 font-medium
                            {{
                                request()->routeIs('super-admin.administrators.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Administrators
                    </a>

                @endif

                {{-- PROFILE --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="flex max-w-32 min-w-0 items-center gap-2 rounded-full border border-orange-200 px-3 py-2 font-semibold
                        {{
                            request()->routeIs('profile.*')
                                ? 'bg-orange-500 text-white'
                                : 'bg-orange-50 text-orange-600 hover:bg-orange-100'
                        }}"
                >
                    <span class="shrink-0">👤</span>

                    <span class="truncate">
                        {{ auth()->user()->name }}
                    </span>
                </a>

                {{-- LOGOUT --}}
                <form
                    action="{{ url('/logout') }}"
                    method="POST"
                    class="shrink-0"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg px-2 py-2 font-semibold text-red-500 hover:bg-red-50 hover:text-red-600"
                    >
                        Logout
                    </button>
                </form>

            @endauth

        </div>

        {{-- MOBILE MENU BUTTON --}}
        <button
            id="menu-button"
            type="button"
            class="shrink-0 text-2xl xl:hidden"
            aria-label="Open menu"
            aria-controls="mobile-menu"
            aria-expanded="false"
        >
            ☰
        </button>

    </nav>

    {{-- MOBILE NAVIGATION --}}
    <div
        id="mobile-menu"
        class="hidden border-t bg-white px-6 pb-5 xl:hidden"
    >

        <div class="flex flex-col gap-2 pt-4">

            {{-- GUEST AND ADOPTER LINKS --}}
            @if (! auth()->check() || auth()->user()->role === 'adopter')

                <a
                    href="{{ route('home') }}"
                    class="rounded-lg px-3 py-2 font-medium
                        {{
                            request()->routeIs('home') && ! request()->has('public')
                                ? 'bg-orange-100 text-orange-600'
                                : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                        }}"
                >
                    Home
                </a>

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

                <a
                    href="{{
                        auth()->check() && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#how-it-works'
                            : route('home') . '#how-it-works'
                    }}"
                    class="rounded-lg px-3 py-2 font-medium text-gray-600 hover:bg-orange-50 hover:text-orange-500"
                >
                    How It Works
                </a>

                <a
                    href="{{
                        auth()->check() && auth()->user()->role === 'adopter'
                            ? route('home', ['public' => 1]) . '#about'
                            : route('home') . '#about'
                    }}"
                    class="rounded-lg px-3 py-2 font-medium text-gray-600 hover:bg-orange-50 hover:text-orange-500"
                >
                    About Us
                </a>

            @endif

            {{-- GUEST --}}
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

            {{-- LOGGED-IN USERS --}}
            @auth

                {{-- ADOPTER --}}
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

                {{-- ADMIN AND SUPER ADMIN --}}
                @if (in_array(auth()->user()->role, ['admin', 'super_admin']))

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
                        href="{{ route('admin.account-approvals.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.account-approvals.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Account Approvals
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

                    {{-- NEW REPORTS LINK --}}
                    <a
                        href="{{ route('admin.reports.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('admin.reports.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Reports
                    </a>

                @endif

                {{-- SUPER ADMIN --}}
                @if (auth()->user()->role === 'super_admin')

                    <a
                        href="{{ route('super-admin.administrators.index') }}"
                        class="rounded-lg px-3 py-2 font-medium
                            {{
                                request()->routeIs('super-admin.administrators.*')
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'text-gray-600 hover:bg-orange-50 hover:text-orange-500'
                            }}"
                    >
                        Administrators
                    </a>

                @endif

                {{-- PROFILE --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="mt-2 flex items-center gap-2 rounded-xl border border-orange-200 px-4 py-3 font-semibold
                        {{
                            request()->routeIs('profile.*')
                                ? 'bg-orange-500 text-white'
                                : 'bg-orange-50 text-orange-600'
                        }}"
                >
                    <span>👤</span>
                    <span class="min-w-0 break-words">
                        {{ auth()->user()->name }}
                    </span>
                </a>

                {{-- LOGOUT --}}
                <form
                    action="{{ url('/logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg px-3 py-2 text-left font-semibold text-red-500 hover:bg-red-50"
                    >
                        Logout
                    </button>

                </form>

            @endauth

        </div>

    </div>

</header>

{{-- FLASH MESSAGES --}}
@if (session('success'))

    <div class="mx-auto mt-4 max-w-7xl px-6">
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    </div>

@endif

@if (session('error'))

    <div class="mx-auto mt-4 max-w-7xl px-6">
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    </div>

@endif

{{-- PAGE CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-gray-900 text-gray-300">

    <div class="mx-auto max-w-7xl px-6 py-10">

        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

            <div class="flex items-center gap-4">

                <img
                    src="{{ asset('images/pawfect-logo.png') }}"
                    alt="Pawfect Match Logo"
                    class="h-14 w-14 rounded-full object-cover"
                >

                <div>

                    <h3 class="text-xl font-bold text-white">
                        Pawfect Match
                    </h3>

                    <p class="mt-1 text-sm text-gray-400">
                        Bayambang Animal Shelter
                    </p>

                </div>

            </div>

            <div class="md:text-right">

                <p class="font-semibold text-white">
                    Bayambang, Pangasinan
                </p>

                <p class="mt-2 text-sm text-gray-400">
                    Give a pet a second chance at a loving home.
                </p>

            </div>

        </div>

    </div>

    <div class="border-t border-gray-800 px-6 py-5 text-center text-sm text-gray-500">
        © {{ date('Y') }} Pawfect Match.
        All rights reserved.
    </div>

</footer>

{{-- MOBILE MENU --}}
<script>
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');

        menuButton.setAttribute(
            'aria-expanded',
            !mobileMenu.classList.contains('hidden')
        );
    });
</script>

</body>
</html>