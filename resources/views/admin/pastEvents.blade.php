@extends('components.adminLayout')

@section('title', 'Past Events')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">📁 Past Events</h1>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.events.past') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or venue" class="input input-bordered w-full" />
        <input type="date" name="from" value="{{ request('from') }}" class="input input-bordered w-full" />
        <input type="date" name="to" value="{{ request('to') }}" class="input input-bordered w-full" />
        <select name="organizer" class="select select-bordered w-full">
            <option value="">All Organizers</option>
            @foreach ($organizers as $org)
                <option value="{{ $org->id }}" {{ request('organizer') == $org->id ? 'selected' : '' }}>
                    {{ $org->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary w-full">
            <x-heroicon-o-funnel class="w-5 h-5 mr-1" /> Filter
        </button>
    </form>

    @if($events->isEmpty())
        <div class="bg-base-200 p-6 rounded-lg text-center shadow">
            <p class="text-lg text-gray-500">No past events found.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Organizer</th>
                        <th>Venue</th>
                        <th>Booked Seats</th>
                        <th>Total Sales</th>
                        <th>Revenue</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="font-semibold">{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</td>
                            <td>{{ \App\Models\User::where('id',$event->user_id)->first()->name ?? 'N/A' }}</td>
                            <td>{{ $event->venue }}</td>
                            <td>{{ $event->bookings->sum('number_of_tickets') ?? 0 }}</td>
                            <td>₹{{ $event->bookings->sum('amount_paid') ?? 0 }}</td>
                            <td>₹{{ $event->bookings->sum('amount_paid')*0.3 ?? 0 }}</td>
                            <td>
                                <button onclick="document.getElementById('viewModal-{{ $event->id }}').showModal()" class="btn btn-sm btn-info">
                                    <x-heroicon-o-eye class="w-4 h-4 mr-1" /> View
                                </button>
                            </td>
                        </tr>

                        {{-- View Modal --}}
                        <dialog id="viewModal-{{ $event->id }}" class="modal">
                            <div class="modal-box max-w-2xl">
                                <h3 class="font-bold text-xl mb-4">{{ $event->title }}</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        @if($event->image)
                                            <img src="{{$event->image}}" alt="Event Image" class="rounded-lg shadow w-full h-48 object-cover mb-4">
                                        @endif

                                        <p><strong>ID:</strong> {{ $event->id }}</p>
                                        <p><strong>Date:</strong> {{ $event->date }}</p>
                                        <p><strong>Time:</strong> {{ $event->time }}</p>
                                        <p><strong>Venue:</strong> {{ $event->venue }}</p>
                                        <p><strong>Price:</strong> ₹{{ $event->price }}</p>
                                    </div>

                                    <div>
                                        <p><strong>Organizer:</strong> {{ \App\Models\User::where('id',$event->user_id)->first()->name ?? 'N/A' }}</p>
                                        <p><strong>Booked Seats:</strong> {{ $event->bookings->sum('number_of_tickets') }}</p>
                                        <p><strong>Total Seats:</strong>{{$event->total_tickets}}</p>
                                        <p><strong>Total Sales:</strong> ₹{{ $event->bookings->sum('amount_paid') }}</p>
                                        <p><strong>Revenue:</strong> ₹{{ $event->bookings->sum('amount_paid')*0.3 }}</p>
                                        <p><strong>Description:</strong></p>
                                        <p class="text-sm mt-1">{{ $event->description }}</p>
                                    </div>
                                </div>

                                <div class="modal-action">
                                    <form method="dialog">
                                        <button class="btn">Close</button>
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
