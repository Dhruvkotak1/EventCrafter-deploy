<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EventCrafter OTP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Inline styles for email compatibility */
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f5;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .header {
      text-align: center;
      padding-bottom: 20px;
    }
    .header h1 {
      color: #3b82f6;
    }
    .otp-box {
      text-align: center;
      font-size: 32px;
      letter-spacing: 5px;
      background: #f0f4ff;
      padding: 15px;
      border-radius: 10px;
      margin: 20px auto;
      color: #1e3a8a;
      font-weight: bold;
      width: fit-content;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #888;
      margin-top: 30px;
    }
    .btn {
      display: inline-block;
      margin-top: 25px;
      padding: 10px 20px;
      background-color: #3b82f6;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
    .note {
      font-size: 13px;
      color: #555;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>EventCrafter</h1>
      <p>Your One-Stop Event Management Platform</p>
    </div>

    <p>We received a request to reset your password. Use the following OTP to complete the process:</p>

    <div class="otp-box">
      {{ $otp }}
    </div>

    <p class="note">This OTP is valid for the next <strong>10 minutes</strong>. Do not share it with anyone.</p>


    <div class="footer">
      <p>Need help? Contact us at <a href="mailto:support@eventcrafter.com">support@eventcrafter.com</a></p>
      <p>&copy; {{ now()->year }} EventCrafter. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
