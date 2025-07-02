@extends('components.layout')

@section('title', 'Give Feedback')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-center mb-6">📝 Give or Update Feedback</h2>

    <div class="bg-info/10 text-info p-4 mb-6 text-sm rounded">
        <strong>Note:</strong> You can give or update feedback only for events you've attended.
    </div>

    @if ($attendedEventsWithBooking->isEmpty())
        <div class="text-center bg-base-200 p-8 rounded shadow">
            <p class="text-lg">No past events found for feedback submission.</p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach ($attendedEventsWithBooking as $item)
                @php
                    $event = $item->event;
                    $feedback = $event->user_feedback;
                    $bookingId = $item->booking_id;
                @endphp

                <div class="bg-base-100 p-4 rounded shadow flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $event->title }}</h3>
                        <p class="text-sm text-base-content/70">
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} at {{ $event->time }} | {{ $event->venue }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Booking ID: {{ $bookingId }}</p>
                    </div>

                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('feedbackModal-{{ $event->id }}').showModal()">
                        {{ $feedback ? 'Update Feedback' : 'Give Feedback' }}
                    </button>
                </div>

                <!-- Feedback Modal -->
                <dialog id="feedbackModal-{{ $event->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg mb-4">{{ $feedback ? 'Update' : 'Submit' }} Feedback – {{ $event->title }}</h3>
                        <form action="{{ $feedback ? route('feedbacks.update', $feedback->id) : route('feedbacks.store') }}" method="POST">
                            @csrf
                            @if($feedback)
                                @method('PUT')
                            @endif

                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="booking_id" value="{{ $bookingId }}">

                            <div class="form-control mb-4">
                                <label class="label">Rating</label>
                                <div class="rating rating-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" class="mask mask-star" {{ $feedback && $feedback->rating == $i ? 'checked' : '' }} required />
                                    @endfor
                                </div>
                            </div>

                            <div class="form-control mb-4">
                                <label class="label">Feedback</label>
                                <textarea name="feedback" class="textarea textarea-bordered" rows="4" placeholder="Write your thoughts..." required>{{ $feedback ? $feedback->feedback : '' }}</textarea>
                            </div>

                            <div class="modal-action">
                                <button type="submit" class="btn btn-success">{{ $feedback ? 'Update' : 'Submit' }}</button>
                                <form method="dialog">
                                    <button class="btn">Cancel</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </dialog>
            @endforeach
        </div>
    @endif
</div>
@endsection
