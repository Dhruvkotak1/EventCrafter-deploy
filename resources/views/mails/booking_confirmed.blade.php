<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #570df8;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            color: #333;
        }
        .content h2 {
            margin-bottom: 10px;
        }
        .content p {
            margin: 6px 0;
        }
        .footer {
            background-color: #f0f0f0;
            color: #666;
            text-align: center;
            padding: 12px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎟️ EventCrafter</h1>
            <p>Booking Confirmation</p>
        </div>
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            <p>Thank you for booking with <strong>EventCrafter</strong>!</p>

            <p><strong>Event:</strong> {{ $event->title }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
            <p><strong>Time:</strong> {{ $event->time }}</p>
            <p><strong>Venue:</strong> {{ $event->venue }}</p>

            <hr>

            <p><strong>Tickets Booked:</strong> {{ $booking->number_of_tickets }}</p>
            <p><strong>Total Amount Paid:</strong> ₹{{ number_format($booking->number_of_tickets * $event->price, 2) }}</p>

            <p class="mt-4">Please show this email or your booking ID at the entry.</p>

            <p style="margin-top: 24px;">Enjoy your event!<br>— The EventCrafter Team</p>
        </div>
        <div class="footer">
            &copy; {{ now()->year }} EventCrafter. All rights reserved.
        </div>
    </div>
</body>
</html>
