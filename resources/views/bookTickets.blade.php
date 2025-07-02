@extends('components.layout')

@section('title', 'Book Event')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-8 bg-base-200 rounded shadow">
    <h2 class="text-3xl font-bold mb-6 text-center">🎟️ Book Tickets for: {{ $event->title }}</h2>

    <!-- Event Overview -->
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <!-- Left: Image -->
        <div class="w-full md:w-1/2">
            <img src="{{ $event->image }}" alt="{{ $event->title }}" class="rounded w-full h-64 object-cover">
        </div>

        <!-- Divider -->
        <div class="hidden md:block w-px bg-base-content/20"></div>

        <!-- Right: Info -->
        <div class="w-full md:w-1/2 space-y-2">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
            <p><strong>Time:</strong> {{ $event->time }}</p>
            <p><strong>Venue:</strong> {{ $event->venue }}</p>
            <p><strong>Price:</strong> ₹{{ number_format($event->price, 2) }} per ticket</p>
            <p><strong>Total Tickets:</strong> {{ $event->total_tickets }}</p>
            <p><strong>Tickets Booked:</strong> {{ $event->tickets_booked }}</p>
            <p class="text-success"><strong>Tickets Left:</strong> {{ $event->tickets_left }}</p>
            <p class="mt-2 text-sm text-base-content/70">{{ $event->description }}</p>
        </div>
    </div>

    <!-- Booking Form Centered -->
    <div class="max-w-md mx-auto bg-base-100 p-6 rounded shadow">
        <form id="booking-form">
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Number of Tickets</span>
                </label>
                <input type="number" name="quantity" id="quantity" min="1" max="{{ $event->tickets_left }}"
                    class="input input-bordered" required>
                <span class="text-error text-sm hidden" id="error-msg">Invalid quantity</span>
            </div>

            <div class="mb-4">
                <p><strong>Total Amount:</strong> ₹<span id="total-price">0</span></p>
            </div>

            @if ($event->tickets_left > 0)
                <button type="button" class="btn btn-primary w-full" onclick="showConfirmModal()">💳 Pay & Book</button>
            @else
                <button class="btn btn-disabled w-full">Sold Out</button>
            @endif
        </form>
    </div>
</div>

<!-- Confirm Modal -->
<dialog id="confirmModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-2">Confirm Booking</h3>
        <p class="mb-4">You are about to book <span id="confirm-tickets">0</span> ticket(s) for a total of ₹<span id="confirm-amount">0</span>.</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Cancel</button>
            </form>
            <form action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="quantity" id="confirm-quantity">
                <button type="submit" class="btn btn-success">Pay ₹<span id="pay-now">0</span></button>
            </form>
        </div>
    </div>
</dialog>
<script>
    const quantityInput = document.getElementById("quantity");
    const totalPriceDisplay = document.getElementById("total-price");
    const confirmModal = document.getElementById("confirmModal");
    const confirmAmount = document.getElementById("confirm-amount");
    const confirmTickets = document.getElementById("confirm-tickets");
    const confirmQtyInput = document.getElementById("confirm-quantity");
    const payNow = document.getElementById("pay-now");
    const maxTickets = {{ $event->tickets_left }};
    const pricePerTicket = {{ $event->price }};
    const errorMsg = document.getElementById("error-msg");

    quantityInput?.addEventListener("input", () => {
        const qty = parseInt(quantityInput.value) || 0;
        if (qty > maxTickets || qty < 1) {
            errorMsg.classList.remove('hidden');
        } else {
            errorMsg.classList.add('hidden');
        }
        totalPriceDisplay.textContent = (qty * pricePerTicket).toFixed(2);
    });

    function showConfirmModal() {
        const qty = parseInt(quantityInput.value) || 0;
        if (qty > maxTickets || qty < 1) {
            errorMsg.classList.remove('hidden');
            return;
        }

        confirmTickets.textContent = qty;
        confirmAmount.textContent = (qty * pricePerTicket).toFixed(2);
        payNow.textContent = (qty * pricePerTicket).toFixed(2);
        confirmQtyInput.value = qty;

        confirmModal.showModal();
    }
</script>

@endsection


