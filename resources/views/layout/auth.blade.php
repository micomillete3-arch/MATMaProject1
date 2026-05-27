<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Access') | MATMA Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --page-bg-dark: #134b4b;
            --page-bg-light: #7f9f8f;
            --card-start: #f8f4eb;
            --card-mid: #edf2eb;
            --card-end: #f7efd7;
            --heading: #114b4c;
            --body: #657c7d;
            --label: #284f51;
            --accent: #e37849;
            --field-bg: #dce5f5;
            --field-border: #bcc7de;
            --button-start: #1a5a59;
            --button-end: #dd7548;
            --success-bg: #dbf1e3;
            --success-text: #1f6c47;
            --error-bg: #fae1df;
            --error-text: #a23f3d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 32px;
            display: grid;
            place-items: center;
            font-family: 'Manrope', sans-serif;
            background: linear-gradient(135deg, var(--page-bg-dark) 0%, #1b5b59 45%, var(--page-bg-light) 100%);
            color: var(--body);
        }

        .auth-card {
            width: min(780px, 100%);
            padding: 54px 52px 46px;
            border-radius: 38px;
            background: linear-gradient(135deg, rgba(248, 244, 235, 0.98) 0%, rgba(237, 242, 235, 0.96) 68%, rgba(247, 239, 215, 0.94) 100%);
            box-shadow: 0 28px 60px rgba(12, 38, 39, 0.22);
        }

        .eyebrow {
            margin: 0 0 18px;
            font-size: 0.86rem;
            font-weight: 800;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .auth-card h1 {
            margin: 0;
            font-family: 'Fraunces', serif;
            font-size: clamp(2.6rem, 5vw, 4rem);
            line-height: 0.96;
            color: var(--heading);
        }

        .lead {
            max-width: 34ch;
            margin: 24px 0 0;
            font-size: 1rem;
            line-height: 1.9;
            color: var(--body);
        }

        .alert {
            margin-top: 22px;
            padding: 14px 18px;
            border-radius: 16px;
            font-weight: 700;
        }

        .alert.success {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .alert.error {
            background: var(--error-bg);
            color: var(--error-text);
        }

        .form-grid {
            display: grid;
            gap: 18px;
            margin-top: 30px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--label);
        }

        .form-group input {
            width: 100%;
            border: 1px solid var(--field-border);
            border-radius: 22px;
            padding: 17px 20px;
            background: var(--field-bg);
            color: #171717;
            font: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #8fa0c3;
            box-shadow: 0 0 0 4px rgba(143, 160, 195, 0.18);
        }

        .submit-button {
            margin-top: 12px;
            border: 0;
            border-radius: 22px;
            padding: 18px 24px;
            background: linear-gradient(90deg, var(--button-start), var(--button-end));
            color: #fff5ea;
            font: inherit;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
        }

        .helper-copy {
            max-width: 38ch;
            margin: 24px 0 0;
            font-size: 0.96rem;
            line-height: 1.8;
            color: var(--body);
        }

        @media (max-width: 640px) {
            body {
                padding: 16px;
            }

            .auth-card {
                padding: 34px 22px 28px;
                border-radius: 28px;
            }

            .lead,
            .helper-copy {
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <main class="auth-card">
        <p class="eyebrow">@yield('card_eyebrow', 'Portal access')</p>
        <h1>@yield('card_title', 'Welcome back')</h1>
        @hasSection('card_copy')
            <p class="lead">@yield('card_copy')</p>
        @endif

        @if (session('status'))
            <div class="alert success">{{ session('status') }}</div>
        @endif

        @if (session('message'))
            <div class="alert error">{{ session('message') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        @yield('form')

        @hasSection('helper_copy')
            <p class="helper-copy">@yield('helper_copy')</p>
        @endif
    </main>
</body>
</html>
