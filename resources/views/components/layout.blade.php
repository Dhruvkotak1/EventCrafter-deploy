@extends('components.theme')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventCrafter</title>
    @vite('resources/css/app.css')
    <style>
        .active {
            font-weight: bold;
            border-bottom: 2px solid hsl(var(--p));
            color: hsl(var(--p));
        }


        .toast-fade {
            animation: fadeIn 0.5s ease, fadeOut 0.5s ease 2.5s forwards;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-base-100 text-base-content">

    <!-- Navbar -->
    <div class="navbar bg-neutral text-neutral-content sticky top-0 z-50 shadow-md">
        <!-- Left: Logo -->
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-2xl">EventCrafter</a>
        </div>

        <!-- Center: Desktop Menu -->
        <div class="hidden md:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('features') }}"
                        class="{{ request()->is('features') ? 'active' : '' }}">Features</a></li>
                <li><a href="{{ route('events.browse') }}"
                        class="{{ request()->is('events/browse') ? 'active' : '' }}">Events</a></li>
                @if (auth()->check())
                    <li><a href="/dashboard"
                            class="{{ request()->is('customer/dashboard') || request()->is('organizer/dashboard') || request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                    </li>
                @elseif (auth()->guard('admin')->check())
                    <li><a href="{{route('admin.dashboard')}}"
                        class="{{request()->is('admin/dashboard') ? 'active' : ''}}">Dashboard</a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>

        <!-- Right Side: Theme, Profile, Mobile Menu -->
        <div class="flex items-center gap-3">
            <!-- Desktop Theme Switcher -->
            <select id="theme-switcher"
                class="select select-sm bg-base-200 text-base-content border border-base-content/20 hidden md:block">
                <option disabled selected>🎨 Theme</option>
                <option value="light">☀️ Light</option>
                <option value="dark">🌙 Dark</option>
                <option value="cupcake">🧁 Cupcake</option>
                <option value="abyss">🌌 Abyss</option>
                <option value="lemonade">🍋 Lemonade</option>
                <option value="night">🌃 Night</option>
                <option value="acid">🧪 Acid</option>
                <option value="dracula">🧛 Dracula</option>
            </select>

            <!-- Profile Icon (only for logged in) -->
            @if (auth()->check())
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-8 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-full h-full"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z">
                                </path>
                            </svg>
                        </div>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[2] p-2 shadow bg-base-200 text-base-content rounded-box w-40">
                        <li><a href="{{ route('profile.show', Auth::user()->id) }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @elseif (auth()->guard('admin')->check())
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-8 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-full h-full"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z">
                                </path>
                            </svg>
                        </div>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[2] p-2 shadow bg-base-200 text-base-content rounded-box w-40">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Mobile Menu -->
            <div class="dropdown dropdown-end md:hidden">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[3] p-2 shadow bg-base-200 text-base-content rounded-box w-52">
                    <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('features') }}"
                            class="{{ request()->is('features') ? 'active' : '' }}">Features</a></li>
                    <li><a href="{{ route('events.browse') }}"
                            class="{{ request()->is('events/browse') ? 'active' : '' }}">Events</a></li>
                            @if (auth()->check())
                            <li><a href="/dashboard"
                                    class="{{ request()->is('customer/dashboard') || request()->is('organizer/dashboard') || request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                            </li>
                        @elseif (auth()->guard('admin')->check())
                            <li><a href="{{route('admin.dashboard')}}"
                                class="{{request()->is('admin/dashboard') ? 'active' : ''}}">Dashboard</a>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
                            </li>
                        @endif

                    <li>
                        <select id="theme-switcher-mobile"
                            class="select select-sm w-full mt-1 bg-base-300 text-base-content border border-base-content/20">
                            <option disabled selected>🎨 Theme</option>
                            <option value="light" class="bg-base-200 text-base-content">☀️ Light</option>
                            <option value="dark" class="bg-base-200 text-base-content">🌙 Dark</option>
                            <option value="cupcake" class="bg-base-200 text-base-content">🧁 Cupcake</option>
                            <option value="abyss" class="bg-base-200 text-base-content">🌌 Abyss</option>
                            <option value="lemonade" class="bg-base-200 text-base-content">🍋 Lemonade</option>
                            <option value="night" class="bg-base-200 text-base-content">🌃 Night</option>
                            <option value="acid" class="bg-base-200 text-base-content">🧪 Acid</option>
                            <option value="dracula" class="bg-base-200 text-base-content">🧛 Dracula</option>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </div>





    <!-- Toast Notifications -->


    <div class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 space-y-2 w-full max-w-md px-4">

        @if (session('success'))
            <div class="alert alert-success shadow-lg toast-fade flex justify-between items-center">
                <span>✅ {{ session('success') }}</span>
                <button class="btn btn-sm btn-circle btn-ghost ml-2"
                    onclick="this.closest('.alert').remove()">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error shadow-lg toast-fade  flex justify-between items-center">
                <span>❌ {{ session('error') }}</span>
                <button class="btn btn-sm btn-circle btn-ghost ml-2"
                    onclick="this.closest('.alert').remove()">✕</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning shadow-lg toast-fade  flex justify-between items-center">
                <ul class="list-disc list-inside text-sm mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn btn-sm btn-circle btn-ghost ml-4"
                    onclick="this.closest('.alert').remove()">✕</button>

            </div>
        @endif

    </div>


    <!-- Content -->
    <main class="min-h-[calc(100vh-10rem)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer footer-center p-4 bg-neutral text-neutral-content rounded">
        <div>
            <p>© 2025 EventCrafter — All rights reserved</p>
        </div>
    </footer>

    <script>
        const themeSwitcher = document.getElementById('theme-switcher-mobile');
        themeSwitcher.addEventListener('change', (e) => {
            const selectedTheme = e.target.value;
            document.documentElement.setAttribute('data-theme', selectedTheme);
            localStorage.setItem('theme', selectedTheme);
        });

        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                const themeSwitcher = document.getElementById('theme-switcher-mobile');
                if (themeSwitcher) themeSwitcher.value = savedTheme;
            }
        });
    </script>
    <script>
        const themeSwitcher2 = document.getElementById('theme-switcher');
        themeSwitcher2.addEventListener('change', (e) => {
            const selectedTheme = e.target.value;
            document.documentElement.setAttribute('data-theme', selectedTheme);
            localStorage.setItem('theme', selectedTheme);
        });

        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                const themeSwitcher2 = document.getElementById('theme-switcher');
                if (themeSwitcher) themeSwitcher.value = savedTheme;
            }
        });
    </script>


</body>
