<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        li strong {
            color: #333;
        }
        .cta-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Notification</h1>
        <div class="content">
            <p>Dear  @if($recipientType == 'teacher') {{ $emailData['teacher_name']  }} @else {{ $emailData['student_name']}} @endif,</p>

            <p>This is to notify you about a new booking.</p>

            <ul>
                <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($emailData['date'])->format('m/d/Y') }}</li>
                <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($emailData['time'])->format('H:i') }}</li>
                @if(isset($emailData['student_name']) && $recipientType == 'teacher')
                    <li><strong>Student:</strong> {{ $emailData['student_name'] }}</li>
                @endif
                @if(isset($emailData['teacher_name']) && $recipientType == 'student')
                    <li><strong>Teacher:</strong> {{ $emailData['teacher_name'] }}</li>
                @endif
            </ul>

            @if($recipientType == 'teacher')
                <p>We kindly request you to prepare for the session. Please make sure to be available at the scheduled time.</p>
                {{-- <a href="{{ $emailData['join_url'] ?? '#' }}" class="cta-button">Join the Meeting</a> --}}
            @elseif($recipientType == 'student')
                <p>Your session is scheduled with {{ $emailData['teacher_name'] }}. Make sure to join on time!</p>
                {{-- <a href="{{ $emailData['join_url'] ?? '#' }}" class="cta-button">Join the Meeting</a> --}}
            @endif
        </div>

        <div class="footer">
            <p>Thank you for using our service!</p>
            <p>If you have any questions, feel free to contact us at info@epsychology.com.</p>
        </div>
    </div>
</body>
</html>
