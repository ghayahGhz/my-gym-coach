<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyGymCoach — تسجيل الدخول</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=League+Spartan:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --accent: #896CFE; --accent2: #B3A0FF; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100dvh;
            background: linear-gradient(160deg, #4B3F9E 0%, #6B52D1 40%, #896CFE 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
            font-family: 'League Spartan', sans-serif;
        }
        .auth-card {
            background: #fff;
            border-radius: 24px;
            padding: 2.25rem 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .logo-wrap { text-align: center; margin-bottom: 1.5rem; }
        .logo-wrap img { height: 90px; width: auto; }
        .tagline { color: #555; font-size: .95rem; text-align: center; margin-bottom: 1.75rem; line-height: 1.5; }
        label { display: block; font-size: .82rem; color: #666; font-weight: 600; margin-bottom: .3rem; }
        .field { margin-bottom: 1rem; }
        .input-wrap { position: relative; }
        .mgc-input {
            width: 100%; padding: .7rem 1rem; border-radius: 12px;
            border: 1.5px solid #E0DAFF; background: #FAFAFA;
            color: #232323; font-family: 'League Spartan', sans-serif;
            font-size: 1rem; outline: none; transition: border-color .2s;
        }
        .mgc-input:focus { border-color: var(--accent); background: #fff; }
        .eye-btn {
            position: absolute; left: .75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #999; font-size: 1.1rem;
        }
        .btn-primary {
            width: 100%; padding: .85rem; background: linear-gradient(90deg, #6B52D1, #896CFE);
            color: #fff; font-family: 'Poppins', sans-serif; font-weight: 700;
            font-size: 1rem; border: none; border-radius: 14px; cursor: pointer;
            margin-top: .5rem; transition: opacity .2s; display: flex; align-items: center;
            justify-content: center; gap: .5rem;
        }
        .btn-primary:hover { opacity: .9; }
        .divider { display: flex; align-items: center; gap: .75rem; margin: 1.25rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #E5E5E5; }
        .divider span { color: #aaa; font-size: .85rem; }
        .btn-google {
            width: 100%; padding: .8rem; background: #fff; border: 1.5px solid #E5E5E5;
            border-radius: 14px; cursor: pointer; font-family: 'League Spartan', sans-serif;
            font-size: .95rem; color: #333; display: flex; align-items: center;
            justify-content: center; gap: .6rem; transition: border-color .2s;
        }
        .btn-google:hover { border-color: var(--accent); }
        .auth-links { display: flex; justify-content: space-between; margin-top: 1.25rem; }
        .auth-links a { color: var(--accent); font-size: .85rem; text-decoration: none; font-weight: 600; }
        .auth-links a:hover { text-decoration: underline; }
        .error-msg { color: #e53e3e; font-size: .8rem; margin-top: .3rem; }
        .alert-success { background: #F0FFF4; border: 1px solid #9AE6B4; color: #276749; border-radius: 10px; padding: .75rem 1rem; font-size: .88rem; margin-bottom: 1rem; }
        .remember-row { display: flex; align-items: center; gap: .5rem; margin-top: -.25rem; margin-bottom: .75rem; }
        .remember-row input { accent-color: var(--accent); width: 16px; height: 16px; cursor: pointer; }
        .remember-row label { margin: 0; font-size: .85rem; color: #666; cursor: pointer; }
    </style>
</head>
<body>
<div class="auth-card">

    <div class="logo-wrap">
        <img src="{{ asset('images/logo-icon.svg') }}" alt="MyGymCoach">
    </div>

    <p class="tagline">سجّل دخولك لمتابعة رحلتك الرياضية</p>

    @if(session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="mgc-input" value="{{ old('email') }}" autocomplete="email" required>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label>كلمة المرور</label>
            <div class="input-wrap">
                <input type="password" name="password" id="password" class="mgc-input" autocomplete="current-password" required>
                <button type="button" class="eye-btn" onclick="togglePwd()">👁</button>
            </div>
        </div>

        <div class="remember-row">
            <input type="checkbox" name="remember" id="remember" value="1">
            <label for="remember">تذكرني</label>
        </div>

        <button type="submit" class="btn-primary">
            <span>→</span> تسجيل الدخول
        </button>
    </form>

    <div class="auth-links">
        <a href="{{ route('register') }}">إنشاء حساب جديد</a>
        <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
    </div>

</div>

<script>
function togglePwd() {
    const p = document.getElementById('password');
    p.type = p.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
