@extends('components.theme')
@extends('components.layout')

@section('title','Organizer Dashboard')

@section('content')
<div class="container mx-auto max-w-screen-xl px-4 py-8 space-y-8">
    <!-- Greeting -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight">Hello, {{ Auth::user()->name }} 👋</h1>
        <span class="badge badge-info badge-lg animate-pulse">Organizer</span>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="stat-figure text-secondary">
                <x-heroicon-o-presentation-chart-bar class="w-10 h-10 text-primary" />
            </div>
            <div class="stat-title">Total Events</div>
            <div class="stat-value">{{ $stats['total_events'] }}</div>
            <div class="stat-desc">Created by you</div>
        </div>
        <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="stat-figure text-secondary">
                <x-heroicon-o-calendar-days class="w-10 h-10 text-primary" />
            </div>
            <div class="stat-title">Upcoming Events</div>
            <div class="stat-value">{{ $stats['upcoming_events'] ?? 0 }}</div>
            <div class="stat-desc">In next 30 days</div>
        </div>
        <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="stat-figure text-secondary">
                <x-heroicon-o-clipboard-document-list class="w-10 h-10 text-primary" />
            </div>
            <div class="stat-title">Total Tickets Sold</div>
            <div class="stat-value">{{ $stats['total_bookings'] ?? 0 }}</div>
            <div class="stat-desc">Across all events</div>
        </div>
        <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="stat-figure text-secondary">
                <x-heroicon-o-star class="w-10 h-10 text-primary" />
            </div>
            <div class="stat-title">Avg. Rating</div>
            <div class="stat-value">{{ $stats['average_rating'] ?? 'N/A' }}</div>
            <div class="stat-desc">Based on feedback</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card bg-base-200 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Quick Actions</h2>
            <div class="flex flex-wrap gap-4 mt-4 justify-between">
                <a href="{{ route('organizers.createEvent') }}" class="btn btn-primary btn-wide">➕ Create New Event</a>
                <a href="{{ route('organizers.manageEvent') }}" class="btn btn-accent btn-wide">🛠️ Manage Events</a>
                <a href="{{ route('organizers.viewFeedback') }}" class="btn btn-info btn-wide">📝 View Feedback</a>
                <a href="{{ route('profile.show',Auth::user()->id) }}" class="btn btn-secondary btn-wide">✨ Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Management -->
    <div class="card bg-base-200 shadow-xl">
        <div class="card-body overflow-x-auto">
            <h2 class="card-title mb-4">Your Upcoming Events</h2>
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Tickets Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingEvents as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td>{{ $event->tickets_booked }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6">You have no upcoming events</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
