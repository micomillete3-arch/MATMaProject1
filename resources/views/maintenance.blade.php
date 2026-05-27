<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            font-family: Arial, sans-serif;
            background: linear-gradient(180deg, #eef3f8 0%, #dfe8f1 100%);
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .maintenance-card {
            width: min(680px, 100%);
            padding: 40px 32px;
            border: 1px solid #d6dbe1;
            border-radius: 14px;
            background: linear-gradient(180deg, #ffffff 0%, #f4f7fb 100%);
            box-shadow: 0 14px 30px rgba(44, 62, 80, 0.12);
            text-align: center;
        }

        .maintenance-card h1 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #2c3e50;
            font-size: 2rem;
        }

        .maintenance-card p {
            margin: 0 auto 14px;
            max-width: 520px;
            color: #4b5d6f;
            line-height: 1.7;
            font-size: 1rem;
        }

        .maintenance-badge {
            display: inline-block;
            margin-bottom: 18px;
            padding: 8px 14px;
            border-radius: 999px;
            background-color: #fff3cd;
            color: #7a5b00;
            font-weight: bold;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        <div class="maintenance-badge">Temporarily Unavailable</div>
        <h1>We are doing maintenance</h1>
        <p>Sorry, the site is currently down for maintenance. Please check back later.</p>
        <p>We are updating the application and will bring everything back online as soon as possible.</p>
    </div>
</body>
</html>
