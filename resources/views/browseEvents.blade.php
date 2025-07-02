@extends('components.layout')

@section('title', 'Browse Events')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6 text-center">🎟️ Browse & Book Events</h2>
    <form method="GET" action="{{ route('events.browse') }}" class="bg-base-200 p-4 rounded mb-6 shadow">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="venue" value="{{ request('venue') }}" placeholder="Search by Venue"
                class="input input-bordered w-full">
    
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price"
                class="input input-bordered w-full">
    
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price"
                class="input input-bordered w-full">
    
            <input type="date" name="date" value="{{ request('date') }}" class="input input-bordered w-full">
        </div>
    
        <div class="mt-4 flex justify-end gap-2">
            <button type="submit" class="btn btn-primary btn-sm">🔍 Filter</button>
            <a href="/events/browse" class="btn btn-neutral btn-sm">❌ Clear</a>
        </div>
    </form>
    

    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
        @if ($events->count() > 0)
        @foreach ($events as $event)
        <div class="card bg-base-100 shadow-md border">
            <figure><img src="{{ $event->image }}" alt="{{ $event->title }}" class="h-40 w-full object-cover" /></figure>
            <div class="card-body">
                <h2 class="card-title">{{ $event->title }}</h2>
                <p class="text-sm">{{ Str::limit($event->description, 100) }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                <p><strong>Venue:</strong> {{ $event->venue }}</p>
                <p><strong>Price:</strong> ₹{{ number_format($event->price, 2) }}</p>
                <p><strong>Tickets Left:</strong> {{ $event->tickets_left}}</p>

                <div class="card-actions justify-end mt-3">
                    <a href="{{route('events.show',$event->id)}}"><button class="btn btn-primary btn-sm">Book</button></a>
                </div>
            </div>
        </div>        
        @endforeach
    </div>


        @else
        <section class="flex items-center justify-center w-full h-[50vh]">
            <div class="text-center">
                <h3 class="text-2xl font-semibold mb-2">😕 No Events Found</h3>
                <p class="text-base-content/70">
                    Try adjusting your filters or 
                    <a href="{{ route('events.browse') }}" class="link link-primary">view all events</a>.
                </p>
            </div>
        </section>
    @endif
</div>
@endsection
