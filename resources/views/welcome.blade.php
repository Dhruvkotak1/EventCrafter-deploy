@extends('components.theme')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventCrafter - Home</title>
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
</head>

<body class="bg-base-100 text-base-content">

    <!-- Sticky Navbar with high contrast -->
    <div class="navbar bg-neutral text-neutral-content sticky top-0 z-50 shadow-md">
        <!-- Left: Logo -->
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-2xl">EventCrafter</a>
        </div>

        <!-- Center: Desktop Menu -->
        <div class="hidden md:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{route('features')}}" class="{{ request()->is('features') ? 'active' : '' }}">Features</a></li>
                <li><a href="{{route('events.browse')}}" class="{{ request()->is('events/browse') ? 'active' : '' }}">Events</a></li>
                @auth
                <li><a href="/dashboard"
                        class="{{ request()->is('customer/dashboard') || request()->is('organizer/dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
                </li>
            @endauth            </ul>
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
            @auth
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
                        <li><a href="{{route('profile.show',Auth::user()->id)}}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

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
                    <li><a href="{{route('features')}}" class="{{ request()->is('features') ? 'active' : '' }}">Features</a></li>
                    <li><a href="{{route('events.browse')}}" class="{{ request()->is('events/browse') ? 'active' : '' }}">Events</a></li>
                    @auth
                    <li><a href="/dashboard"
                            class="{{ request()->is('customer/dashboard') || request()->is('organizer/dashboard') ? 'active' : '' }}">Dashboard</a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
                    </li>
                @endauth
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
    </div>

    <!-- Hero Section -->
    <section class="flex flex-col justify-center items-center text-center px-4 py-10">
        <h1 class="text-5xl font-bold mb-4">Welcome to EventCrafter</h1>
        <p class="text-lg mb-6 max-w-xl">Plan, manage, and succeed in your events with ease. From small gatherings to
            grand functions, EventCrafter has your back.</p>
        <div class="flex gap-4">
            <a href="{{ route('register') }}"><button class="btn btn-primary">Create Account</button></a>
            <a href="{{ route('events.browse') }}"><button class="btn btn-outline">Browse Events</button></a>
        </div>
    </section>

    <!-- Featured Events Section -->
    <section class="py-10 px-4 text-center">
        <h2 class="text-3xl font-bold mb-6">Featured Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card shadow-lg image-full">
                <figure><img
                        src="https://media.istockphoto.com/id/1363104923/photo/diverse-modern-office-businessman-leads-business-meeting-with-managers-talks-uses.webp?a=1&b=1&s=612x612&w=0&k=20&c=P3p7QksVY2syzlJnEKZYy-AUcnD5hym97liMskfriaE="
                        alt="Tech Conference" /></figure>
                <div class="card-body">
                    <h3 class="text-xl font-bold">Tech Conference 2025</h3>
                    <p>Explore the future of AI and cloud with global experts.</p>
                    <div class="card-actions justify-center">
                        <button class="btn btn-accent">Register</button>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg image-full">
                <figure><img
                        src="https://plus.unsplash.com/premium_photo-1661502996011-cbd328de50f2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c3RhcnR1cCUyMG1lZXR8ZW58MHx8MHx8fDA%3D"
                        alt="Startup Meetup" /></figure>
                <div class="card-body">
                    <h3 class="text-xl font-bold">Startup Meetup</h3>
                    <p>Network with founders, investors, and creators in your city.</p>
                    <div class="card-actions justify-center">
                        <button class="btn btn-accent">Join Now</button>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg image-full">
                <figure><img
                        src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bXVzaWMlMjBwYXJ0eXxlbnwwfHwwfHx8MA%3D%3D"
                        alt="Music Fest" /></figure>
                <div class="card-body">
                    <h3 class="text-xl font-bold">Music Fest</h3>
                    <p>Catch live performances from top indie artists and bands.</p>
                    <div class="card-actions justify-center">
                        <a href="/bookings"><button class="btn btn-accent">Book Ticket</button></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-10 px-4 text-center">
        <h2 class="text-3xl font-bold mb-6">Why Choose EventCrafter?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title justify-center">📅 Easy Scheduling</h3>
                    <p>Book, edit, and cancel events effortlessly with our intuitive interface.</p>
                </div>
            </div>
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title justify-center">🏢 Multiple Venues</h3>
                    <p>Choose from a variety of venues available for different event types and sizes.</p>
                </div>
            </div>
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title justify-center">📊 Real-Time Analytics</h3>
                    <p>Track event registrations, ticket sales, and performance in real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer footer-center p-4 bg-neutral text-neutral-content rounded">
        <div>
            <p>© 2025 EventCrafter — All rights reserved</p>
        </div>
    </footer>

    <!--Toast Notifications-->

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
