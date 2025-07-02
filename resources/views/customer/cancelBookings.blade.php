@extends('components.layout')

@section('title', 'Cancel Bookings')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6 text-center">❌ Cancel Bookings</h2>

    <!-- Policy Note -->
    <div class="bg-warning/20 text-warning p-4 rounded mb-6 text-sm">
        <strong>Note:</strong> Bookings can only be cancelled if the event starts in more than <strong>24 hours</strong>.
        Cancellations within 24 hours of the event start time are not allowed.
    </div>

    @if ($bookings->isEmpty())
        <div class="text-center bg-base-200 p-8 rounded shadow">
            <p class="text-lg">You have no upcoming bookings available for cancellation.</p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach ($bookings as $booking)
                @php
                    $event = $booking->event;
                    $eventStart = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
                    $canCancel = now()->diffInHours($eventStart, false) >= 24;
                @endphp

                <div class="bg-base-100 rounded shadow p-4 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $event->title }}</h3>
                        <p class="text-sm text-base-content/70">
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} at {{ $event->time }} | {{ $event->venue }}
                        </p>
                        <p class="mt-1">Tickets: {{ $booking->number_of_tickets }} | Total: ₹{{ $booking->number_of_tickets * $event->price }}</p>
                    </div>

                    @if ($canCancel)
                    <button class="btn btn-error btn-sm" onclick="document.getElementById('cancelModal-{{ $booking->id }}').showModal()">Cancel Booking</button>

                    <!-- Cancel Confirmation Modal -->
                    <dialog id="cancelModal-{{ $booking->id }}" class="modal">
                        <div class="modal-box">
                            <h3 class="font-bold text-lg">Are you sure you want to cancel this booking?</h3>
                            <p class="py-2">Event: <strong>{{ $event->title }}</strong></p>
                            <div class="modal-action">
                                <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error">Yes, Cancel</button>
                                </form>
                                <form method="dialog">
                                    <button class="btn">No</button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                    @else
                        <span class="badge badge-warning">Cannot Cancel (Event in &lt; 24h)</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
