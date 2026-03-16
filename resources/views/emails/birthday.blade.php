<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.8;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        .content p {
            margin: 15px 0;
            font-size: 15px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #555;
        }
        .company {
            font-weight: bold;
            color: #1a5276;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">🎉 Happy Birthday! 🎂✨</div>

        <p class="greeting">Dear {{ $customer->full_name }},</p>

        <div class="content">
            <p>On this special day, the entire team at <span class="company">Falcon International Consultants</span> wishes you a very Happy Birthday 🎂✨</p>

            <p>May God bless you with many more years of health, happiness and success. May all your dreams come true and may this year bring new opportunities and achievements into your life.</p>

            <p>We sincerely wish for the smooth and successful completion of your ongoing process and that you soon celebrate your new beginning abroad. 🌍✈️</p>

            <p>Thank you for your continued trust in <span class="company">Falcon International Consultants</span>.</p>
        </div>

        <div class="signature">
            <p>Warm regards,<br>
            <strong>Team FALCON International Consultants</strong></p>
        </div>
    </div>
</body>
</html>
