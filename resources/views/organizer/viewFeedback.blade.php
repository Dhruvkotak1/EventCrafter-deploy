@extends('components.layout')


@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">📝 Feedbacks for Your Events</h2>

    @forelse($feedbacks as $feedback)
        <div class="card bg-base-200 shadow-md mb-6">
            <div class="card-body">
                <h3 class="text-xl font-semibold">{{ $feedback->event->title }}</h3>
                <p class="text-sm text-gray-500">By: {{ $feedback->user->name }} | {{ $feedback->created_at->diffForHumans() }}</p>
                <p class="mt-2">{{ $feedback->feedback }}</p>
                @if($feedback->rating)
                    <div class="mt-2">
                        <span class="font-semibold">Rating:</span>
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-400' }}">★</span>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info shadow-lg">
            <span>No feedbacks available yet for your events.</span>
        </div>
    @endforelse
</div>
@endsection
