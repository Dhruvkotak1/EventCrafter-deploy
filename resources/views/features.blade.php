@extends('components.layout')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-screen-xl space-y-16">

    <!-- Hero Section -->
    <section class="text-center space-y-4">
        <h1 class="text-4xl lg:text-5xl font-bold">Empower Your Events with EventCrafter 🚀</h1>
        <p class="text-lg opacity-80">Create. Discover. Experience. The ultimate platform for event organizers and attendees.</p>
        <div class="mt-4">
            <a href="{{ route('events.browse') }}" class="btn btn-primary btn-lg">Explore Events</a>
        </div>
    </section>

    <!-- Features Section -->
    <section>
        <h2 class="text-3xl font-bold text-center mb-10">Core Features</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-6 bg-base-200 rounded-xl text-center space-y-3">
                <div class="flex justify-center">
                    <x-heroicon-o-plus-circle class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-xl font-semibold">Create Events Easily</h3>
                <p>Create public or private events in minutes with simple forms and built-in validations.</p>
            </div>
            <div class="p-6 bg-base-200 rounded-xl text-center space-y-3">
                <div class="flex justify-center">
                    <x-heroicon-o-calendar-days class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-xl font-semibold">Book & Manage</h3>
                <p>Securely book your seat and view your upcoming events all in one place.</p>
            </div>
            <div class="p-6 bg-base-200 rounded-xl text-center space-y-3">
                <div class="flex justify-center">
                    <x-heroicon-o-chart-bar class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-xl font-semibold">Live Statistics</h3>
                <p>Track total bookings, upcoming events, and feedback with live event dashboards.</p>
            </div>
            <div class="p-6 bg-base-200 rounded-xl text-center space-y-3">
                <div class="flex justify-center">
                    <x-heroicon-o-device-phone-mobile class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-xl font-semibold">Mobile-Friendly Design</h3>
                <p>Access the platform anytime, anywhere. Fully responsive and optimized for all devices.</p>
            </div>
            <div class="p-6 bg-base-200 rounded-xl text-center space-y-3">
                <div class="flex justify-center">
                    <x-heroicon-o-lock-closed class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-xl font-semibold">Secure & Fast</h3>
                <p>Data privacy and speed ensured with modern Laravel backend and secure authentication.</p>
            </div>
            <div class="p-6 bg-base-200 rounded-xl text-center space-y-3">
                <div class="flex justify-center">
                    <x-heroicon-o-bell-alert class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-xl font-semibold">Real-Time Notifications</h3>
                <p>Stay updated via email or SMS with instant booking and event change alerts.</p>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="text-center space-y-10">
        <h2 class="text-3xl font-bold">How It Works</h2>
        <div class="flex flex-col md:flex-row justify-center items-center gap-6">
            <div class="bg-base-200 p-6 rounded-xl w-full md:w-1/3">
                <h3 class="text-xl font-semibold mb-2">1. Create or Join</h3>
                <p>Signup to organize your own events or explore from hundreds of upcoming events.</p>
            </div>
            <div class="bg-base-200 p-6 rounded-xl w-full md:w-1/3">
                <h3 class="text-xl font-semibold mb-2">2. Book with Ease</h3>
                <p>Find events you love, view details, and book your seats with just a few clicks.</p>
            </div>
            <div class="bg-base-200 p-6 rounded-xl w-full md:w-1/3">
                <h3 class="text-xl font-semibold mb-2">3. Attend & Enjoy</h3>
                <p>Receive confirmations, get reminders, and enjoy seamless event experiences.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="text-center">
        <h2 class="text-3xl font-bold mb-10">What Our Users Say</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-base-200 p-6 rounded-xl">
                <p class="italic">“EventCrafter made organizing our college fest so easy! Loved the simple UI.”</p>
                <div class="mt-4 font-semibold">– Aisha Patel</div>
            </div>
            <div class="bg-base-200 p-6 rounded-xl">
                <p class="italic">“Booking events has never been this fast. I even got reminders before the event!”</p>
                <div class="mt-4 font-semibold">– Raj Sharma</div>
            </div>
            <div class="bg-base-200 p-6 rounded-xl">
                <p class="italic">“Finally, a platform that understands organizers! Live stats helped us stay prepared.”</p>
                <div class="mt-4 font-semibold">– Neha Joshi</div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="text-center space-y-4">
        <h2 class="text-3xl font-bold">Ready to Create or Join an Event?</h2>
        <p class="opacity-80">Sign up today and explore a world of events near you.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started for Free</a>
    </section>

</div>
@endsection
