<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') | MATMA Portal @else MATMA Portal @endif</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-cream: #f6efe5;
            --bg-mint: #dceae4;
            --surface: rgba(255, 250, 243, 0.78);
            --surface-strong: rgba(255, 250, 243, 0.94);
            --surface-muted: rgba(239, 247, 244, 0.88);
            --line: rgba(14, 61, 62, 0.12);
            --text-main: #183536;
            --text-soft: #607775;
            --accent: #d96c47;
            --accent-deep: #0f4b4c;
            --accent-gold: #f2b95d;
            --white-soft: #fffaf3;
            --shadow: 0 28px 80px rgba(12, 32, 33, 0.16);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at 10% 20%, rgba(242, 185, 93, 0.35), transparent 24%),
                radial-gradient(circle at 88% 12%, rgba(44, 145, 134, 0.22), transparent 22%),
                linear-gradient(140deg, #f1e7d6 0%, var(--bg-cream) 48%, var(--bg-mint) 100%);
            position: relative;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(8px);
            opacity: 0.65;
            z-index: 0;
        }

        body::before {
            width: 320px;
            height: 320px;
            background: rgba(217, 108, 71, 0.14);
            top: -110px;
            right: -90px;
        }

        body::after {
            width: 260px;
            height: 260px;
            background: rgba(15, 75, 76, 0.12);
            left: -70px;
            bottom: 10%;
        }

        a {
            color: inherit;
        }

        .site-shell {
            width: min(1200px, calc(100% - 32px));
            margin: 0 auto;
            padding: 28px 0 36px;
            position: relative;
            z-index: 1;
        }

        .site-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            padding: 18px 24px;
            border: 1px solid rgba(255, 250, 243, 0.7);
            border-radius: 28px;
            background: rgba(255, 250, 243, 0.62);
            box-shadow: 0 18px 50px rgba(12, 32, 33, 0.08);
            backdrop-filter: blur(18px);
            position: sticky;
            top: 16px;
            z-index: 5;
        }

        .brand-lockup {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-mark {
            width: 50px;
            height: 50px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, var(--accent-deep), var(--accent));
            color: var(--white-soft);
            font-weight: 800;
            letter-spacing: 0.12em;
            box-shadow: 0 14px 30px rgba(15, 75, 76, 0.22);
        }

        .brand-copy {
            min-width: 0;
        }

        .brand-copy p {
            margin: 0;
        }

        .brand-copy .eyebrow-text {
            font-size: 0.72rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: 800;
        }

        .brand-copy .brand-title {
            font-family: 'Fraunces', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-deep);
        }

        .site-nav {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-link,
        .nav-button {
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.55);
            color: var(--accent-deep);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 700;
            transition: transform 180ms ease, background 180ms ease, color 180ms ease, box-shadow 180ms ease;
        }

        .nav-link:hover,
        .nav-button:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, 0.86);
            box-shadow: 0 12px 24px rgba(15, 75, 76, 0.08);
        }

        .nav-link.active {
            background: var(--accent-deep);
            color: var(--white-soft);
            border-color: transparent;
        }

        .nav-button {
            cursor: pointer;
            font-family: inherit;
        }

        .nav-form {
            margin: 0;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) auto;
            gap: 22px;
            align-items: end;
            margin-top: 22px;
            padding: 34px;
            border-radius: 34px;
            border: 1px solid rgba(255, 250, 243, 0.72);
            background:
                radial-gradient(circle at top right, rgba(242, 185, 93, 0.18), transparent 28%),
                linear-gradient(145deg, rgba(255, 250, 243, 0.92), rgba(240, 247, 244, 0.84));
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            right: -120px;
            bottom: -140px;
            border-radius: 50%;
            background: rgba(15, 75, 76, 0.1);
        }

        .hero-copy {
            position: relative;
            z-index: 1;
        }

        .hero-copy h1 {
            margin: 0;
            font-family: 'Fraunces', serif;
            font-size: clamp(2.1rem, 4vw, 3.6rem);
            line-height: 0.98;
            max-width: 11ch;
            color: var(--accent-deep);
        }

        .section-kicker {
            margin: 0 0 14px;
            font-size: 0.76rem;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--accent);
        }

        .hero-text {
            max-width: 58ch;
            margin: 16px 0 0;
            font-size: 1.02rem;
            line-height: 1.8;
            color: var(--text-soft);
        }

        .hero-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .pill,
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid var(--line);
            color: var(--accent-deep);
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: flex-end;
            position: relative;
            z-index: 1;
        }

        .hero-stat {
            min-width: 180px;
            padding: 15px 18px;
            border-radius: 22px;
            border: 1px solid rgba(255, 250, 243, 0.68);
            background: rgba(255, 255, 255, 0.76);
            box-shadow: 0 16px 34px rgba(15, 75, 76, 0.1);
            text-decoration: none;
            color: inherit;
        }

        .hero-stat-label {
            display: block;
            font-size: 0.74rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 8px;
        }

        .hero-stat-value {
            display: block;
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--accent-deep);
        }

        .hero-stat-note {
            display: block;
            margin-top: 6px;
            color: var(--text-soft);
            font-size: 0.88rem;
            line-height: 1.55;
        }

        .page-frame {
            margin-top: 22px;
            padding: 28px;
            border-radius: 34px;
            border: 1px solid rgba(255, 250, 243, 0.72);
            background: var(--surface);
            backdrop-filter: blur(16px);
            box-shadow: 0 24px 60px rgba(12, 32, 33, 0.1);
        }

        .content-grid,
        .link-grid,
        .metric-grid,
        .two-column-grid {
            display: grid;
            gap: 18px;
        }

        .metric-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .two-column-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .panel-card,
        .metric-card {
            border-radius: 26px;
            border: 1px solid var(--line);
            box-shadow: 0 16px 34px rgba(15, 75, 76, 0.06);
        }

        .panel-card {
            padding: 24px;
            background: var(--surface-strong);
        }

        .feature-card {
            background:
                radial-gradient(circle at top right, rgba(242, 185, 93, 0.18), transparent 28%),
                linear-gradient(140deg, rgba(255, 249, 239, 0.96), rgba(229, 242, 238, 0.92));
        }

        .panel-card h2,
        .panel-card h3,
        .metric-card strong {
            color: var(--accent-deep);
        }

        .panel-card h2,
        .panel-card h3 {
            margin: 0 0 12px;
            font-family: 'Fraunces', serif;
            font-size: 1.55rem;
        }

        .panel-card p,
        .metric-card p {
            margin: 0;
            color: var(--text-soft);
            line-height: 1.75;
        }

        .metric-card {
            padding: 20px;
            background: linear-gradient(145deg, rgba(255, 250, 243, 0.94), rgba(239, 247, 244, 0.9));
        }

        .metric-card span {
            display: block;
            font-size: 0.75rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .metric-card strong {
            display: block;
            font-size: 1.15rem;
            line-height: 1.35;
            margin-bottom: 8px;
        }

        .link-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .quick-link {
            display: block;
            padding: 18px 20px;
            border-radius: 22px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease;
        }

        .quick-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 32px rgba(15, 75, 76, 0.1);
            border-color: rgba(15, 75, 76, 0.2);
        }

        .quick-link strong {
            display: block;
            margin-bottom: 8px;
            color: var(--accent-deep);
            font-size: 1rem;
        }

        .quick-link span {
            color: var(--text-soft);
            line-height: 1.7;
            font-size: 0.92rem;
        }

        .button-row,
        .tag-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .button-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 999px;
            background: var(--accent-deep);
            color: var(--white-soft);
            text-decoration: none;
            font-weight: 800;
            border: 1px solid transparent;
            transition: transform 180ms ease, box-shadow 180ms ease, background 180ms ease;
        }

        .button-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(15, 75, 76, 0.18);
        }

        .button-link.secondary {
            background: transparent;
            color: var(--accent-deep);
            border-color: var(--line);
        }

        .definition-list {
            display: grid;
            gap: 14px;
            margin: 0;
        }

        .definition-item {
            padding: 16px 18px;
            border-radius: 20px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.7);
        }

        .definition-item dt {
            margin: 0 0 8px;
            font-size: 0.74rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--accent);
        }

        .definition-item dd {
            margin: 0;
            color: var(--accent-deep);
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.6;
        }

        .notice {
            margin-bottom: 18px;
            padding: 15px 18px;
            border-radius: 18px;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .notice.success {
            background: rgba(221, 246, 228, 0.92);
            color: #1f6a47;
            border-color: rgba(31, 106, 71, 0.12);
        }

        .notice.error {
            background: rgba(253, 228, 228, 0.94);
            color: #9d3030;
            border-color: rgba(157, 48, 48, 0.12);
        }

        .site-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 18px 4px 0;
            color: var(--text-soft);
            font-size: 0.92rem;
        }

        .site-footer p {
            margin: 0;
        }

        @media (max-width: 900px) {
            .site-header,
            .hero,
            .two-column-grid {
                grid-template-columns: 1fr;
            }

            .site-header,
            .hero {
                padding: 20px;
            }

            .hero-copy h1 {
                max-width: none;
            }

            .hero-actions {
                justify-content: flex-start;
            }

            .site-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 640px) {
            .site-shell {
                width: min(100%, calc(100% - 20px));
                padding-top: 18px;
            }

            .page-frame {
                padding: 20px;
            }

            .site-header {
                border-radius: 24px;
            }

            .brand-lockup {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="site-shell">
        <header class="site-header">
            <div class="brand-lockup">
                <div class="brand-mark">MT</div>
                <div class="brand-copy">
                    <p class="eyebrow-text">Academic Workspace</p>
                    <p class="brand-title">MATMA Portal</p>
                </div>
            </div>

            <nav class="site-nav">
                @auth
                    <a class="nav-link {{ request()->routeIs(auth()->user()->dashboardRoute()) ? 'active' : '' }}" href="{{ route(auth()->user()->dashboardRoute()) }}">
                        {{ ucfirst(auth()->user()->role) }} Home
                    </a>
                @endauth

                @auth
                    @if (auth()->user()->role === 'admin')
                        @if (Route::has('studentss.index'))
                            <a class="nav-link {{ request()->routeIs('studentss.*') ? 'active' : '' }}" href="{{ route('studentss.index') }}">Students</a>
                        @endif

                        @if (Route::has('degrees.index'))
                            <a class="nav-link {{ request()->routeIs('degrees.*') ? 'active' : '' }}" href="{{ route('degrees.index') }}">Degrees</a>
                        @endif

                        @if (Route::has('teachers.create'))
                            <a class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.create') }}">Add Teacher</a>
                        @endif
                    @endif
                @endauth

                @guest
                    @if (Route::has('degrees.index'))
                        <a class="nav-link {{ request()->routeIs('degrees.*') ? 'active' : '' }}" href="{{ route('degrees.index') }}">Degrees</a>
                    @endif

                    @if (Route::has('studentss.index'))
                        <a class="nav-link {{ request()->routeIs('studentss.*') ? 'active' : '' }}" href="{{ route('studentss.index') }}">Students</a>
                    @endif
                @endguest

                @if (Route::has('aboutUs'))
                    <a class="nav-link {{ request()->routeIs('aboutUs') ? 'active' : '' }}" href="{{ route('aboutUs') }}">About</a>
                @endif

                @auth
                    @if (Route::has('logout'))
                        <form class="nav-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-button">Logout</button>
                        </form>
                    @endif
                @endauth
            </nav>
        </header>

        @unless (trim($__env->yieldContent('hide_hero')))
            <section class="hero">
                <div class="hero-copy">
                    <p class="section-kicker">@yield('eyebrow', 'MATMA portal')</p>
                    <h1>@yield('header', 'Welcome')</h1>
                    <p class="hero-text">@yield('subtitle', 'A calmer place for student records, degree management, and daily portal work.')</p>

                    <div class="hero-meta">
                        @auth
                            <span class="pill">{{ ucfirst(auth()->user()->role) }} access</span>
                        @endauth

                        @hasSection('hero_meta')
                            @yield('hero_meta')
                        @elseif (Route::currentRouteName())
                            <span class="pill">{{ str(Route::currentRouteName())->replace('.', ' ') }}</span>
                        @endif
                    </div>
                </div>

                @hasSection('hero_actions')
                    <div class="hero-actions">
                        @yield('hero_actions')
                    </div>
                @endif
            </section>
        @endunless

        <main class="page-frame">
            @if (session('status'))
                <div class="notice success">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="notice error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>

        <footer class="site-footer">
            <p>@yield('footer', 'Built for cleaner student workflows and less visual clutter.')</p>
            <p>MATMA Portal (c) 2026</p>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
