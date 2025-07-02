<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Ticket</title>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 2cm;
            padding: 0;
            color: #1f2937;
            background-color: #fff;
        }

        .ticket-container {
            max-width: 700px;
            margin: 0 auto;
            border: 2px dashed #4b5563;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 26px;
            margin-bottom: 5px;
            color: #5b21b6;
        }

        .header p {
            font-size: 14px;
            color: #6b7280;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h3 {
            font-size: 18px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
            margin-bottom: 10px;
            color: #111827;
        }

        .info p {
            margin: 4px 0;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h1>🎟️ EventCrafter Ticket</h1>
            <p>Thank you for booking with us!</p>
        </div>

        <div class="section">
            <h3>Event Details</h3>
            <div class="info">
                <p><strong>Event Name:</strong> {{ $event->title }}</p>
                <p><strong>Date:</strong> {{\Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                <p><strong>Time:</strong> {{ $event->time }}</p>
                <p><strong>Venue:</strong> {{ $event->venue }}</p>
            </div>
        </div>

        <div class="section">
            <h3>Booking Details</h3>
            <div class="info">
                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Total Seats:</strong> {{ $booking->number_of_tickets }}</p>
                <p><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y')  }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Please carry this ticket along with a valid ID proof.</p>
            <p>&copy; {{ date('Y') }} EventCrafter</p>
        </div>
    </div>
</body>
</html>
