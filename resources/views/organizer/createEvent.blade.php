@extends('components.theme')
@extends('components.layout')

@section('content')
<div class="container mx-auto max-w-3xl px-4 py-8">
    <div class="card bg-base-200 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl mb-4">🎉 Create a New Event</h2>
            <form action="{{ route('events.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="form-control">
                        <label for="title" class="label">
                            <span class="label-text">Event Title <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" id="title" class="input input-bordered" placeholder="Enter event title" required value="{{ old('title') }}">
                        @error('title') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Venue -->
                    <div class="form-control">
                        <label for="venue" class="label">
                            <span class="label-text">Venue <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="venue" id="venue" class="input input-bordered" placeholder="Event location" required value="{{ old('venue') }}">
                        @error('venue') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date -->
                    <div class="form-control">
                        <label for="date" class="label">
                            <span class="label-text">Event Date <span class="text-error">*</span></span>
                        </label>
                        <input type="date" name="date" id="date" class="input input-bordered" required value="{{ old('date') }}">
                        @error('date') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Time -->
                    <div class="form-control">
                        <label for="time" class="label">
                            <span class="label-text">Event Time <span class="text-error">*</span></span>
                        </label>
                        <input type="time" name="time" id="time" class="input input-bordered" required value="{{ old('time') }}">
                        @error('time') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price -->
                    <div class="form-control">
                        <label for="price" class="label">
                            <span class="label-text">Ticket Price (₹) <span class="text-error">*</span></span>
                        </label>
                        <input type="number" step="0.01" min="0" name="price" id="price" class="input input-bordered" placeholder="E.g. 299.00" required value="{{ old('price') }}">
                        @error('price') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Total Tickets -->
                    <div class="form-control">
                        <label for="total_tickets" class="label">
                            <span class="label-text">Total Tickets <span class="text-error">*</span></span>
                        </label>
                        <input type="number" min="1" name="total_tickets" id="total_tickets" class="input input-bordered" placeholder="E.g. 100" required value="{{ old('total_tickets') }}">
                        @error('total_tickets') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Image URL -->
                <div class="form-control mt-6">
                    <label for="image" class="label">
                        <span class="label-text">Event Banner URL <span class="text-error">*</span></span>
                    </label>
                    <input type="url" name="image" id="image" class="input input-bordered" placeholder="https://example.com/banner.jpg" required value="{{ old('image') }}">
                    @error('image') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="form-control mt-6">
                    <label for="description" class="label">
                        <span class="label-text">Event Description <span class="text-error">*</span></span>
                    </label>
                    <textarea name="description" id="description" rows="4" class="textarea textarea-bordered" placeholder="Brief overview of the event" required>{{ old('description') }}</textarea>
                    @error('description') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Submit -->
                <div class="form-control mt-8">
                    <button class="btn btn-primary w-full">🚀 Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
