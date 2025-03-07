<!DOCTYPE html>
<html>
<head>
    <title>Feedback Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            background: #ffffff;
            padding: 20px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s;
        }
        .button:hover {
            background: #0056b3;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">We Value Your Feedback!</div>
        <div class="content">
            Hi there,<br><br>
            Your opinion matters to us! Please take a moment to share your feedback by clicking the button below.
        </div>
        <a href="{{ $feedbackLink }}" class="button" target="_blank">Give Feedback</a>
        <div class="footer">
            Thank you for your time! <br> — The Team
        </div>
    </div>
</body>
</html>
