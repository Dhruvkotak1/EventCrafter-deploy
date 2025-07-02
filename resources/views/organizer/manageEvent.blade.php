@extends('components.layout')

@section('title', 'Manage Events')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">📅 Manage Your Events</h2>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $index => $event)
                <tr>
                    <td>{{$event->id}}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{  \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                    <td>{{ $event->venue }}</td>
                    <td>₹{{ number_format($event->price, 2) }}</td>
                    <td class="space-x-2">
                        @php
                            $eventDateTime = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
                        @endphp
                    
                        <!-- View button (always available) -->
                        <button class="btn btn-sm btn-info" onclick="document.getElementById('viewModal-{{ $event->id }}').showModal()">👁 View</button>
                    
                        @if($eventDateTime->isFuture())
                            <!-- Edit & Delete for future events -->
                            <button class="btn btn-sm btn-warning" onclick="document.getElementById('editModal-{{ $event->id }}').showModal()">✏️ Edit</button>
                            <button class="btn btn-sm btn-error" onclick="document.getElementById('deleteModal-{{ $event->id }}').showModal()">🗑 Delete</button>
                        @else
                            <!-- Tooltip for past events -->
                            <div class="tooltip tooltip-top" data-tip="Only upcoming events can be edited or deleted.">
                                <span class="text-xs text-warning">🔒 Edit & Delete Disabled</span>
                            </div>
                        @endif
                    </td>
                </tr>

                <!-- View Modal -->
                <dialog id="viewModal-{{ $event->id }}" class="modal">
                    <div class="modal-box max-h-[75vh] overflow-y-auto">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                          </form>
                        <h3 class="font-bold text-lg mb-2">{{ $event->title }}</h3>
                        <img src="{{ $event->image }}" alt="{{ $event->title }}" class="rounded mb-4 w-full max-h-48 object-cover" />
                        <p><strong>Date:</strong> {{ $event->date }}</p>
                        <p><strong>Time:</strong> {{ $event->time }}</p>
                        <p><strong>Venue:</strong> {{ $event->venue }}</p>
                        <p><strong>Price:</strong> ₹{{ number_format($event->price, 2) }}</p>
                        <p><strong>Tickets:</strong> {{ $event->total_tickets }}</p>
                        <p><strong>Tickets Booked:</strong> {{ $event->tickets_booked }}</p>

                        <p class="mt-2"><strong>Description:</strong></p>
                        <p>{{ $event->description }}</p>
                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn">Close</button>
                            </form>
                        </div>
                    </div>
                </dialog>

                <!-- Edit Modal -->
                <dialog id="editModal-{{ $event->id }}" class="modal">
                    <div class="modal-box max-w-2xl">
                        <h3 class="font-bold text-lg mb-4">Update Event</h3>
                        <form action="{{ route('events.update', $event->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="label"><span class="label-text">Title</span></label>
                                    <input name="title" value="{{ $event->title }}" class="input input-bordered" placeholder="Title" required>
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Venue</span></label>
                                    <input name="venue" value="{{ $event->venue }}" class="input input-bordered" placeholder="Venue" required>
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Date</span></label>
                                    <input type="date" name="date" value="{{ $event->date }}" class="input input-bordered" required>
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Time</span></label>
                                    <input type="time" name="time" value="{{ $event->time }}" class="input input-bordered" required>
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Price (₹)</span></label>
                                    <input type="number" name="price" step="0.01" value="{{ round($event->price,0) }}" class="input input-bordered" placeholder="Price" required>
                                </div>
                                <div>
                                    <label class="label"><span class="label-text">Total Tickets</span></label>
                                    <input type="number" name="total_tickets" value="{{ $event->total_tickets }}" class="input input-bordered" placeholder="Tickets" disabled>
                                </div>
                                <div class="col-span-full">
                                    <label class="label"><span class="label-text">Image URL</span></label>
                                    <input type="url" name="image" value="{{ $event->image }}" class="input input-bordered" placeholder="Image URL" required>
                                </div>
                                <div class="col-span-full">
                                    <label class="label"><span class="label-text">Description</span></label>
                                    <textarea name="description" rows="3" class="textarea textarea-bordered" placeholder="Description" required>{{ $event->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-action">
                                <button class="btn btn-success" type="submit">Update</button>
                            </form>
                                <form method="dialog">
                                    <button class="btn">Cancel</button>
                                </form>
                            </div>
                        
                    </div>
                </dialog>
                <!-- Delete Modal -->
                <dialog id="deleteModal-{{ $event->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="text-lg font-semibold mb-2">Are you sure you want to delete this event?</h3>
                        <p class="mb-4">"{{ $event->title }}" will be permanently removed.</p>
                        <div class="modal-action">
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error">Yes, Delete</button>
                            </form>
                            <form method="dialog">
                                <button class="btn">No</button>
                            </form>
                        </div>
                    </div>
                </dialog>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
