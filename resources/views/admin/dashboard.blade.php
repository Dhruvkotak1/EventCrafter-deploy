@extends('components.adminLayout')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        {{-- Total Events --}}
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <x-heroicon-o-calendar-days class="w-8 h-8 text-blue-600" />
                </div>
                <div class="stat-title">Total Events</div>
                <div class="stat-value text-primary">{{ $totalEvents }}</div>
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-heroicon-o-clock class="w-8 h-8 text-green-600" />
                </div>
                <div class="stat-title">Upcoming Events</div>
                <div class="stat-value text-secondary">{{ $upcomingEvents }}</div>
            </div>
        </div>

        {{-- Registered Users --}}
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-info">
                    <x-heroicon-o-users class="w-8 h-8 text-indigo-500" />
                </div>
                <div class="stat-title">Registered Users</div>
                <div class="stat-value text-info">{{ $totalUsers }}</div>
                <div class="stat-desc">Customers: {{ $totalCustomers }} | Organizers: {{ $totalOrganizers }}</div>
            </div>
        </div>

        {{-- Total Seats Booked --}}
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-warning">
                    <x-heroicon-o-ticket class="w-8 h-8 text-yellow-500" />
                </div>
                <div class="stat-title">Total Seats Booked</div>
                <div class="stat-value text-warning">{{ $totalSeatsBooked }}</div>
                <div class="stat-desc">Out of {{ $totalSeatsAvailable }} total seats</div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <x-heroicon-o-currency-rupee class="w-10 h-10 text-green-500" />
                </div>
                <div class="stat-title">Revenue Stats</div>
                <div class="stat-value text-success">₹{{ $platformRevenue }}</div>
                <div class="stat-desc">Total Sales : ₹{{ $totalRevenue }}</div>
            </div>
        </div>

        {{-- Average Rating --}}
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-pink-500">
                    <x-heroicon-o-star class="w-8 h-8 text-pink-500" />
                </div>
                <div class="stat-title">Average Rating</div>
                <div class="stat-value text-pink-500">{{ round($averageRating, 2) }}/5</div>
                <div class="stat-desc">Based on {{ $totalReviews }} reviews</div>
            </div>
        </div>
    </div>

        {{-- Booking & Revenue Charts --}}
<div class="bg-base-200 p-6 rounded-xl shadow mb-10">
    <h2 class="text-xl font-bold mb-4">📊 Bookings & Revenue Analytics</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Bookings Bar Chart --}}
        <div>
            <h3 class="font-semibold mb-2">Bookings in Last 7 Days</h3>
            <canvas id="bookingsChart" height="150"></canvas>
        </div>

        {{-- Revenue Line Chart --}}
        <div>
            <h3 class="font-semibold mb-2">Revenue in Last 7 Days</h3>
            <canvas id="revenueChart" height="150"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = {!! json_encode($chartLabels) !!};
    const bookingsData = {!! json_encode($chartBookings) !!};
    const revenueData = {!! json_encode($chartRevenue) !!};

    // Bookings Bar Chart
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Bookings',
                data: bookingsData,
                backgroundColor: 'rgba(59, 130, 246, 0.7)', // Tailwind blue-500
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Bookings',
                    font: {
                        size: 16
                    }
                },
                tooltip: {
                    enabled: true
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Bookings'
                    }
                }
            }
        }
    });

    // Revenue Line Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: revenueData,
                fill: true,
                borderColor: 'rgba(34, 197, 94, 1)', // Tailwind green-500
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                tension: 0.3,
                pointBackgroundColor: 'rgba(34, 197, 94, 1)'
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Revenue Trend',
                    font: {
                        size: 16
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                },
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue in ₹'
                    }
                }
            }
        }
    });
</script>


    {{-- Admin Actions --}}
<div class="mt-10">
    <h2 class="text-2xl font-semibold mb-4">🛠 Admin Tools & Management</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Manage Upcoming Events --}}
        <a href="{{ route('admin.events.upcoming') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
            <div class="card-body">
                <h3 class="card-title text-blue-600">
                    <x-heroicon-o-calendar-days class="w-6 h-6" />
                    Manage Upcoming Events
                </h3>
                <p>View and manage events scheduled in the future.</p>
            </div>
        </a>

        {{-- View Past Events --}}
        <a href="{{ route('admin.events.past') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
            <div class="card-body">
                <h3 class="card-title text-green-600">
                    <x-heroicon-o-archive-box class="w-6 h-6" />
                    Past Events
                </h3>
                <p>Check events that have already occurred.</p>
            </div>
        </a>

        {{-- Manage Users --}}
        <a href="{{ route('admin.users.manage') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
            <div class="card-body">
                <h3 class="card-title text-purple-600">
                    <x-heroicon-o-users class="w-6 h-6" />
                    Manage Users
                </h3>
                <p>Manage customer and organizer accounts.</p>
            </div>
        </a>

        {{-- View Bookings --}}
        <a href="{{ route('admin.bookings.view') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
            <div class="card-body">
                <h3 class="card-title text-yellow-600">
                    <x-heroicon-o-ticket class="w-6 h-6" />
                    View Bookings
                </h3>
                <p>See all bookings and event seat allocations.</p>
            </div>
        </a>

        {{-- Feedback Report --}}
        <a href="{{ route('admin.feedbacks.report') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
            <div class="card-body">
                <h3 class="card-title text-pink-600">
                    <x-heroicon-o-chat-bubble-left-right class="w-6 h-6" />
                    Feedback Reports
                </h3>
                <p>See event-wise feedback ratings and user comments.</p>
            </div>
        </a>
    </div>
</div>
</div>
@endsection
