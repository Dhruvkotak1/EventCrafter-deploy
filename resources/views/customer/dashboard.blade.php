@extends('components.layout')


@section('content')
    <div class="container mx-auto max-w-screen-xl px-4 py-8 space-y-8">
        <!-- Greeting -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight">Welcome back, {{ Auth::user()->name }}!</h1>
            <span class="badge badge-secondary badge-lg animate-pulse">Customer</span>
        </div>

        <!-- Stats -->
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
                <div class="stat-figure text-secondary">
                    <x-heroicon-o-calendar class="w-10 h-10 text-secondary" />
                </div>
                <div class="stat-title">Total Bookings</div>
                <div class="stat-value">{{ $stats['total_bookings'] ?? 0 }}</div>
                <div class="stat-desc">Since joining</div>
            </div>
            <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
                <div class="stat-figure text-secondary">
                    <x-heroicon-o-clock class="w-10 h-10 text-secondary" />
                </div>
                <div class="stat-title">Upcoming Events</div>
                <div class="stat-value">{{ $stats['upcoming_events'] ?? 0 }}</div>
                <div class="stat-desc">Next 30 days</div>
            </div>
            <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
                <div class="stat-figure text-secondary">
                    <x-heroicon-o-calendar class="w-10 h-10 text-secondary" />
                </div>
                <div class="stat-title">Events Attended</div>
                <div class="stat-value">{{ $stats['events_attended'] ?? 0 }}</div>
                <div class="stat-desc">Memories made</div>
            </div>
            <div class="stat bg-base-200 shadow-xl transition-transform hover:scale-[1.02]">
                <div class="stat-figure text-secondary">
                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-10 h-10 text-secondary" />
                </div>
                <div class="stat-title">Feedbacks Given</div>
                <div class="stat-value">{{ $stats['feedbacks_given'] ?? 0 }}</div>
                <div class="stat-desc">Thanks for your thoughts!</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Quick Actions</h2>
                <div class="flex flex-wrap gap-4 mt-4 justify-between">
                    <a href="{{ route('events.browse') }}" class="btn btn-primary btn-wide">Browse Events</a>
                    <a href="{{ route('customers.cancelBookings') }}" class="btn btn-accent btn-wide">Cancel Bookings</a>
                    <a href="{{ route('customers.giveEventFeedback') }}" class="btn btn-success btn-wide">Give Event
                        Feedback</a>
                    <a href="{{ route('profile.show',Auth::user()->id) }}" class="btn btn-secondary btn-wide">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- Upcoming Bookings Table -->
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body overflow-x-auto">
                <h2 class="card-title mb-4">Your Upcoming Bookings</h2>
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount Paid</th>
                            <th>Ticket</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingBookings as $index => $booking)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $booking->event->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->event->date)->format('d M Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($booking->amount_paid) }}</td>
                                <td class="flex gap-2">
                                    <a href="{{ route('bookings.show', $booking) }}"
                                        class="btn btn-sm btn-outline">View</a>
                                    <a href="{{ route('bookings.download', $booking) }}"
                                        class="btn btn-sm btn-outline btn-info">Download</a>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">No upcoming bookings — <a
                                        href="{{ route('events.index') }}" class="link link-primary">book an event now!</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recommendations Carousel -->
        <div class="carousel w-full rounded-box shadow-xl">
            {{-- @foreach ($recommendedEvents as $event)
            <div id="event-{{ $event->id }}" class="carousel-item relative w-full">
                <img src="{{ $event->cover_url }}" class="w-full object-cover" alt="{{ $event->title }}" />
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                    <h3 class="text-xl font-bold text-white">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-300">{{ $event->city }} • {{ $event->start_date->format('d M') }}</p>
                    <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm mt-2">View Details</a>
                </div>
            </div>
        @endforeach --}}
        </div>
    </div>
@endsection
