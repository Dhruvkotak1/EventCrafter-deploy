<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to EventCrafter</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #1d232a;
      color: #f3f4f6;
      margin: 0;
      padding: 0;
    }
    .email-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #2a323c;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }
    .header {
      background-color: #3b82f6;
      padding: 20px;
      text-align: center;
      color: white;
    }
    .header h1 {
      margin: 0;
      font-size: 28px;
    }
    .content {
      padding: 30px;
    }
    .content h2 {
      font-size: 22px;
      color: #fbbf24;
    }
    .content p {
      line-height: 1.6;
      margin: 15px 0;
    }
    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #3b82f6;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background-color: #111827;
      color: #9ca3af;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>🎉 Welcome to EventCrafter!</h1>
    </div>
    <div class="content">
      <h2>Hello {{ $username }},</h2>
      <p>
        We're thrilled to have you on board as a <strong>{{ $role }}</strong>!
        Whether you're here to create unforgettable events or explore and book amazing ones — you're in the right place.
      </p>
      <p>
        EventCrafter empowers <strong>organizers</strong> to manage events seamlessly, track bookings, and engage with customers, while <strong>customers</strong> can easily explore, book, and stay updated with personalized event recommendations.
      </p>
      <p>
        Ready to get started? Dive into your dashboard and begin crafting or discovering memorable experiences.
      </p>
      <a href="https://yourdomain.com/login" class="button">Go to Dashboard</a>
    </div>
    <div class="footer">
      © 2025 EventCrafter — Crafted with 💙 for every celebration.
    </div>
  </div>
</body>
</html>
