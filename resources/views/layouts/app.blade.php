<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyGymCoach — {{ $title ?? 'مدربي' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=League+Spartan:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Theme CSS variables based on gender --}}
    @php $gender = isset($profile) ? $profile->gender : 'female'; @endphp
    <style>
        :root {
            --accent:   {{ $gender === 'male' ? '#E2F163' : '#896CFE' }};
            --accent2:  {{ $gender === 'male' ? '#C8D84F' : '#B3A0FF' }};
            --bg:       #232323;
            --card:     #2E2E2E;
            --txt:      #EEEAFF;
            --muted:    #5C5C82;
            --lime:     #E2F163;
            --purple:   #896CFE;
        }
        * { box-sizing: border-box; }
        body {
            background: var(--bg);
            color: var(--txt);
            font-family: 'League Spartan', sans-serif;
            min-height: 100dvh;
            margin: 0;
        }
        h1,h2,h3,h4,h5,h6 { font-family: 'Poppins', sans-serif; }
        .mono { font-family: 'JetBrains Mono', monospace; }

        /* Accent utilities */
        .accent-text  { color: var(--accent); }
        .accent-bg    { background: var(--accent); }
        .accent-border{ border-color: var(--accent); }
        .accent2-text { color: var(--accent2); }

        /* Card */
        .card {
            background: var(--card);
            border-radius: 16px;
            padding: 1rem;
        }
        .card-dark {
            background: #1A1A2E;
            border-radius: 16px;
            padding: 1rem;
        }

        /* Button primary */
        .btn-primary {
            background: var(--accent);
            color: #232323;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: opacity .2s, transform .1s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-primary:hover { opacity: .9; }
        .btn-primary:active { transform: scale(.97); }

        /* Button ghost */
        .btn-ghost {
            background: transparent;
            color: var(--accent);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            border: 2px solid var(--accent);
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            cursor: pointer;
            transition: background .2s;
        }
        .btn-ghost:hover { background: rgba(255,255,255,.05); }

        /* Bottom nav */
        #bottom-nav {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #1A1A2E;
            border-top: 1px solid rgba(255,255,255,.08);
            display: flex;
            z-index: 50;
        }
        #bottom-nav a {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: .6rem .25rem;
            color: var(--muted);
            text-decoration: none;
            font-size: .65rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: color .2s;
        }
        #bottom-nav a.active,
        #bottom-nav a:hover { color: var(--accent); }
        #bottom-nav a svg { width: 22px; height: 22px; margin-bottom: 2px; }

        /* Page content padding for bottom nav */
        .page-content {
            padding-bottom: 80px;
            padding-top: 1rem;
            max-width: 480px;
            margin: 0 auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Top bar */
        #top-bar {
            background: #1A1A2E;
            border-bottom: 1px solid rgba(255,255,255,.08);
            padding: .75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .logo-img { height: 36px; width: auto; object-fit: contain; }

        /* Input styles */
        .mgc-input {
            background: #1A1A1A;
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: 10px;
            color: var(--txt);
            padding: .65rem .9rem;
            font-family: 'League Spartan', sans-serif;
            font-size: 1rem;
            width: 100%;
            outline: none;
            transition: border-color .2s;
        }
        .mgc-input:focus { border-color: var(--accent); }
        .mgc-input::placeholder { color: var(--muted); }

        /* Tags / pills */
        .pill {
            display: inline-flex;
            align-items: center;
            background: rgba(137,108,254,.15);
            color: var(--accent2);
            border-radius: 20px;
            padding: .2rem .7rem;
            font-size: .75rem;
            font-weight: 600;
        }

        /* Progress ring */
        .ring-svg { transform: rotate(-90deg); }
        .ring-track { stroke: rgba(255,255,255,.08); }
        .ring-fill { stroke: var(--accent); stroke-linecap: round; transition: stroke-dashoffset .6s ease; }

        /* Day tab */
        .day-tab {
            padding: .4rem .9rem;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid rgba(255,255,255,.1);
            color: var(--muted);
            transition: all .2s;
            white-space: nowrap;
        }
        .day-tab.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #232323;
        }

        /* Exercise card */
        .ex-card {
            background: var(--card);
            border-radius: 14px;
            padding: .9rem;
            margin-bottom: .75rem;
            border: 1px solid rgba(255,255,255,.05);
            transition: border-color .2s;
        }
        .ex-card.done-card { border-color: var(--lime); opacity: .75; }

        /* Adjuster buttons */
        .adj-btn {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: rgba(255,255,255,.08);
            border: none;
            color: var(--txt);
            font-size: 1rem;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .15s;
        }
        .adj-btn:hover { background: var(--accent); color: #232323; }

        /* Timer circle */
        .timer-ring { transform: rotate(-90deg); }
        .timer-track { fill: none; stroke: rgba(255,255,255,.08); }
        .timer-fill  { fill: none; stroke: var(--lime); stroke-linecap: round; transition: stroke-dashoffset .5s linear; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--muted); border-radius: 4px; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,.7);
            z-index: 100;
            display: flex; align-items: flex-end; justify-content: center;
        }
        .modal-sheet {
            background: #1A1A2E;
            border-radius: 20px 20px 0 0;
            width: 100%; max-width: 480px;
            max-height: 85dvh;
            overflow-y: auto;
            padding: 1.25rem;
        }

        /* Flash message */
        .flash {
            background: var(--accent);
            color: #232323;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        /* ── Splash ─────────────────────────────────────────────── */
        #splash {
            position: fixed; inset: 0; z-index: 9999;
            background: #0F0B1E;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 1.25rem;
            transition: opacity .55s ease, visibility .55s ease;
        }
        #splash.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .spl-ring { position: relative; width: 120px; height: 120px; flex-shrink: 0; }
        .spl-ring svg { position: absolute; inset: 0; }
        .spl-fill {
            fill: none; stroke: var(--accent); stroke-width: 3.5;
            stroke-linecap: round;
            stroke-dasharray: 345;
            stroke-dashoffset: 345;
            animation: spl-spin 1.1s ease forwards .15s;
        }
        @keyframes spl-spin { to { stroke-dashoffset: 0; } }
        .spl-logo {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .spl-logo img {
            width: 70px; opacity: 0; transform: scale(.55);
            animation: spl-pop .5s cubic-bezier(.34,1.56,.64,1) forwards .25s;
        }
        @keyframes spl-pop { to { opacity: 1; transform: scale(1); } }
        .spl-name {
            font-family: 'Poppins', sans-serif; font-weight: 800;
            font-size: 1.4rem; color: #fff; letter-spacing: .3px;
            opacity: 0; animation: spl-up .4s ease forwards .6s;
        }
        .spl-name span { color: var(--accent); }
        .spl-sub {
            font-size: .8rem; color: var(--muted); margin-top: -.6rem;
            opacity: 0; animation: spl-up .38s ease forwards .78s;
        }
        @keyframes spl-up { to { opacity: 1; } }

        /* Push bell */
        #push-bell {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,.07); border: 1.5px solid rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all .2s; color: var(--muted); flex-shrink: 0;
        }
        #push-bell.on { background: rgba(137,108,254,.2); border-color: var(--accent); color: var(--accent); }
    </style>
    @stack('head')
</head>
<body>

{{-- ═══ Splash Screen ═══ --}}
<div id="splash">
    <div class="spl-ring">
        <svg viewBox="0 0 120 120" width="120" height="120">
            <circle cx="60" cy="60" r="54" fill="none" stroke="rgba(137,108,254,.12)" stroke-width="3.5"/>
            <circle cx="60" cy="60" r="54" class="spl-fill" style="transform:rotate(-90deg);transform-origin:60px 60px;"/>
        </svg>
        <div class="spl-logo"><img src="{{ asset('images/logo-icon.svg') }}" alt="logo"></div>
    </div>
    <div class="spl-name">My<span>Gym</span>Coach</div>
    <div class="spl-sub">مدربك الرقمي لصحتك 💪</div>
</div>

{{-- Top Bar --}}
<div id="top-bar">
    <img src="{{ asset('images/logo-full.svg') }}" alt="MyGymCoach" class="logo-img">
    <div style="display:flex;align-items:center;gap:.6rem;">
        @if(isset($profile))
        {{-- Push bell --}}
        <button id="push-bell" onclick="togglePush()" title="الإشعارات">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
        </button>
        <div style="width:32px;height:32px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-weight:700;color:#232323;font-family:'Poppins',sans-serif;">
            {{ mb_substr($profile->name, 0, 1) }}
        </div>
        @endif
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div style="max-width:480px;margin:.5rem auto;padding:0 1rem;">
    <div class="flash">{{ session('success') }}</div>
</div>
@endif

{{-- Main Content --}}
<main class="page-content">
    @yield('content')
</main>

{{-- Bottom Navigation --}}
@isset($profile)
<nav id="bottom-nav">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><path d="M9 21V12h6v9"/></svg>
        الرئيسية
    </a>
    <a href="{{ route('calendar') }}" class="{{ request()->routeIs('calendar') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        التقويم
    </a>
    <a href="{{ route('progress') }}" class="{{ request()->routeIs('progress') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        التقدم
    </a>
    <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        الإعدادات
    </a>
</nav>
@endisset

@stack('scripts')

<script>
// ── Splash Screen ──────────────────────────────────────────────────────────
(function () {
    const splash = document.getElementById('splash');
    if (!splash) return;
    // Hide after animations finish (~1.4 s total) + small buffer
    const hide = () => { splash.classList.add('hidden'); };
    if (document.readyState === 'complete') {
        setTimeout(hide, 200);
    } else {
        window.addEventListener('load', () => setTimeout(hide, 350));
        // Fallback: always hide after 2 s even if load is slow
        setTimeout(hide, 2000);
    }
})();

// ── Web Push ───────────────────────────────────────────────────────────────
const PUSH_KEY = '{{ config("app.vapid_public_key") }}';
const PUSH_CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';

function urlBase64ToUint8(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw = window.atob(base64);
    return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
}

async function initPush() {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;
    try {
        const reg = await navigator.serviceWorker.register('/sw.js');
        const sub = await reg.pushManager.getSubscription();
        const bell = document.getElementById('push-bell');
        if (sub && bell) bell.classList.add('on');
    } catch (_) {}
}

async function togglePush() {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        alert('متصفحك لا يدعم الإشعارات');
        return;
    }

    const reg = await navigator.serviceWorker.register('/sw.js');
    const existing = await reg.pushManager.getSubscription();
    const bell = document.getElementById('push-bell');

    if (existing) {
        // Unsubscribe
        await existing.unsubscribe();
        await fetch('/push/unsubscribe', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN': PUSH_CSRF},
            body: JSON.stringify({ endpoint: existing.endpoint })
        });
        if (bell) bell.classList.remove('on');
    } else {
        // Subscribe
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') { alert('يرجى السماح بالإشعارات من إعدادات المتصفح'); return; }

        const sub = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8(PUSH_KEY)
        });

        const json = sub.toJSON();
        await fetch('/push/subscribe', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN': PUSH_CSRF},
            body: JSON.stringify({
                endpoint: json.endpoint,
                keys: { p256dh: json.keys.p256dh, auth: json.keys.auth }
            })
        });

        if (bell) bell.classList.add('on');

        // Send a welcome test notification
        await fetch('/push/test', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN': PUSH_CSRF}
        });
    }
}

initPush();
</script>
</body>
</html>
