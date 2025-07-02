<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Cancelled</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
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
            background-color: #f87171;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 24px;
            color: #333;
        }
        .content h2 {
            margin-top: 0;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 14px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .info-block {
            background-color: #fef2f2;
            padding: 14px;
            border-left: 4px solid #f87171;
            margin: 16px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h1>EventCrafter</h1>
        <p>Booking Cancellation Confirmation</p>
    </div>
    <div class="content">
        <h2>Hello {{ $user->name }},</h2>
        <p>We're confirming that your booking for the event <strong>{{ $event->title }}</strong> has been successfully cancelled.</p>

        <div class="info-block">
            <p><strong>Event:</strong> {{ $event->title }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
            <p><strong>Time:</strong> {{ $event->time }}</p>
            <p><strong>Venue:</strong> {{ $event->venue }}</p>
            <p><strong>Tickets Cancelled:</strong> {{ $booking->number_of_tickets }}</p>
            <p><strong>Total Refund:</strong> ₹{{ number_format($booking->number_of_tickets * $event->price, 2) }}</p>
        </div>

        <p>If you didn't request this cancellation or believe it was made in error, please contact us immediately.</p>
        <p>We hope to see you at future events!</p>

        <p>— The EventCrafter Team</p>
    </div>
    <div class="footer">
        &copy; {{ now()->year }} EventCrafter. All rights reserved.
    </div>
</div>
</body>
</html>
