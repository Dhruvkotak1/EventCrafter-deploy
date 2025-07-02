@extends('components.adminLayout')

@section('title', 'Manage Upcoming Events')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">📅 Manage Upcoming Events</h1>

    {{-- Search + Filters --}}
    <form method="GET" action="{{ route('admin.events.upcoming') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or venue" class="input input-bordered w-full" />
        <input type="date" name="date" value="{{ request('date') }}" class="input input-bordered w-full" />
        <select name="organizer" class="select select-bordered w-full">
            <option value="">All Organizers</option>
            @foreach ($organizers as $org)
                <option value="{{ $org->id }}" {{ request('organizer') == $org->id ? 'selected' : '' }}>
                    {{ $org->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary w-full">
            <x-heroicon-o-magnifying-glass class="w-5 h-5 mr-1" /> Filter
        </button>
    </form>

    @if($events->isEmpty())
        <div class="bg-base-200 p-6 rounded-lg text-center shadow">
            <p class="text-lg text-gray-500">No upcoming events found.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Organizer</th>
                        <th>Venue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="font-semibold">{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</td>
                            <td>{{ \App\Models\User::where('id',$event->user_id)->first()->name ?? 'N/A' }}</td>
                            <td>{{ $event->venue }}</td>
                            <td class="flex flex-wrap gap-2">
                                <button onclick="document.getElementById('viewModal-{{ $event->id }}').showModal()" class="btn btn-sm btn-info">
                                    <x-heroicon-o-eye class="w-4 h-4 mr-1" /> View
                                </button>

                                <button onclick="document.getElementById('editModal-{{ $event->id }}').showModal()" class="btn btn-sm btn-warning">
                                    <x-heroicon-o-pencil-square class="w-4 h-4 mr-1" /> Edit
                                </button>

                                <button onclick="document.getElementById('deleteModal-{{ $event->id }}').showModal()" class="btn btn-sm btn-error">
                                    <x-heroicon-o-trash class="w-4 h-4 mr-1" /> Delete
                                </button>
                            </td>
                        </tr>

                        {{-- View Modal --}}
                        <dialog id="viewModal-{{ $event->id }}" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg mb-3">{{ $event->title }}</h3>
                                <ul class="space-y-1">
                                    <li><strong>Date:</strong> {{ $event->date }}</li>
                                    <li><strong>Time:</strong> {{ $event->time }}</li>
                                    <li><strong>Organizer:</strong> {{ \App\Models\User::where('id',$event->user_id)->first()->name ?? 'N/A' }}</li>
                                    <li><strong>Venue:</strong> {{ $event->venue }}</li>
                                    <li><strong>Description:</strong> {{ $event->description }}</li>
                                </ul>
                                <form method="dialog" class="mt-4">
                                    <button class="btn">Close</button>
                                </form>
                            </div>
                        </dialog>

                        {{-- Edit Modal --}}
                        <dialog id="editModal-{{ $event->id }}" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg mb-4">Edit Event - {{ $event->title }}</h3>
                                <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-control mb-2">
                                        <label class="label">Title</label>
                                        <input type="text" name="title" class="input input-bordered" value="{{ $event->title }}">
                                    </div>
                                    <div class="form-control mb-2">
                                        <label class="label">Date</label>
                                        <input type="date" name="date" class="input input-bordered" value="{{ $event->date }}">
                                    </div>
                                    <div class="form-control mb-2">
                                        <label class="label">Time</label>
                                        <input type="time" name="time" class="input input-bordered" value="{{ $event->time }}">
                                    </div>
                                    <div class="form-control mb-4">
                                        <label class="label">Venue</label>
                                        <input type="text" name="venue" class="input input-bordered" value="{{ $event->venue }}">
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </form>
                                        <form method="dialog">
                                            <button class="btn">Cancel</button>
                                        </form>
                                    </div>
                                
                            </div>
                        </dialog>

                        {{-- Delete Modal --}}
                        <dialog id="deleteModal-{{ $event->id }}" class="modal">
                            <div class="modal-box">
                                <h3 class="text-lg font-semibold">Delete Confirmation</h3>
                                <p>Are you sure you want to delete <strong>{{ $event->title }}</strong>?</p>
                                <div class="modal-action">
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-error">Yes, Delete</button>
                                    </form>
                                    <form method="dialog">
                                        <button class="btn">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>

                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
