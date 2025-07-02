@extends('components.adminLayout')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-6">📢 Feedback Reports</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
            <div class="bg-base-200 rounded-xl p-4 shadow space-y-2">
                <h2 class="text-lg font-bold truncate">{{ $event['title'] }}</h2>

                <div class="flex items-center gap-2 text-sm text-base-content/70">
                    <span class="text-yellow-400 text-lg">★</span>
                    <span>{{ $event['avgRating'] ?? 'Not feedback yet' }} / 5</span>
                </div>
                

                <button class="btn btn-sm btn-primary" onclick="document.getElementById('modal-{{ $event['id'] }}').showModal()">View All Feedbacks</button>

                {{-- Feedback Modal --}}
                <dialog id="modal-{{ $event['id'] }}" class="modal">
                    <div class="modal-box max-w-3xl">
                        <h3 class="font-bold text-lg mb-2">📝 Feedbacks for {{ $event['title'] }}</h3>
                        <div class="overflow-y-auto max-h-[400px] space-y-4">
                            @forelse ($event['feedbacks'] as $feedback)
                                <div class="border-b pb-2">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-semibold">{{ \App\Models\User::where('id',$feedback['user_id'])->first()->name }} (ID: {{ $feedback['user_id'] }})</span>
                                        <div class="flex">
                                            @for ($i = 0; $i < $feedback['rating']; $i++)
                                                <i class="text-yellow-400">★</i>
                                            @endfor
                                            @for ($i = $feedback['rating']; $i < 5; $i++)
                                                <i class="text-gray-400">★</i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-base-content/80">{{ $feedback['feedback'] }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-base-content/70 italic">No feedbacks available.</p>
                            @endforelse
                        </div>
                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn">Close</button>
                            </form>
                        </div>
                    </div>
                </dialog>
            </div>
        @endforeach
    </div>
</div>
@endsection
