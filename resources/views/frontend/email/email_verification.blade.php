<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }
    .email-container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .header {
      background-color: #007BFF;
      color: #ffffff;
      text-align: center;
      padding: 20px;
      font-size: 24px;
    }
    .body {
      padding: 20px;
      color: #333333;
      line-height: 1.6;
    }
    .button-container {
      text-align: center;
      margin: 20px 0;
    }
    .verify-button {
      background-color: #007BFF;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 24px;
      font-size: 16px;
      border-radius: 4px;
      display: inline-block;
    }
    .verify-button:hover {
      background-color: #0056b3;
      color: #ffffff;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #777777;
      padding: 10px 20px;
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      Verify Your Email
    </div>
    <div class="body">
      <p>Hello,</p>
      <p>Thank you for signing up! Please verify your email address to activate your account.</p>
      <div class="button-container">
        <a href="{{ route('email_verification', ['toke_code' => $token_code]) }}" class="verify-button">Verify Email</a>
      </div>
      <p>If you didn't sign up for this account, you can safely ignore this email.</p>
      <p>Thank you,<br>epsychology Team</p>
    </div>
    <div class="footer">
    <p> <a href="https://epsychology.ca/">www.epsychology.ca</a> &copy; 2024 Your Company. All rights reserved.<br>
        If you have any questions, contact us at info@epsychology.com.</p>
    </div>
  </div>
</body>
</html>
