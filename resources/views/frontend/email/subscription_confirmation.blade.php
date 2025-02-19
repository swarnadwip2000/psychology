<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }
        .subscription-details {
            text-align: left;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .subscription-details ul {
            list-style-type: none;
            padding: 0;
        }
        .subscription-details li {
            padding: 5px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .btn {
            display: inline-block;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 15px;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="header">Subscription Confirmation</div>

        <div class="content">
            <p>Dear <strong>{{ $userSubscription->user_name }}</strong>,</p>
            <p>Thank you for subscribing to <strong>{{ $userSubscription->plan_name }}</strong>. Below are your subscription details:</p>

            <div class="subscription-details">
                <ul>
                    <li><strong>Plan:</strong> {{ $userSubscription->plan_name }}</li>
                    <li><strong>Price:</strong> {{ number_format($userSubscription->plan_price, 2) }} {{ $userSubscription->currency }}</li>
                    <li><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($userSubscription->membership_start_date)->format('F d, Y') }}</li>
                    <li><strong>Expiry Date:</strong> {{ \Carbon\Carbon::parse($userSubscription->membership_expiry_date)->format('F d, Y') }}</li>
                </ul>
            </div>

            <p>We hope you enjoy your membership! If you have any questions, feel free to contact our support team at info@epsychology.com.</p>



            <div class="footer">
                <p> <a href="https://epsychology.ca/">www.epsychology.ca</a> &copy; 2024 Your Company. All rights reserved.</p>
            </div>
        </div>
    </div>

</body>
</html>
