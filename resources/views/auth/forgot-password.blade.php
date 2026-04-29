<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyGymCoach — نسيت كلمة المرور</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=League+Spartan:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        :root { --accent: #896CFE; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100dvh;
            background: linear-gradient(160deg, #4B3F9E 0%, #6B52D1 40%, #896CFE 100%);
            display: flex; align-items: center; justify-content: center; padding: 1.5rem;
            font-family: 'League Spartan', sans-serif;
        }
        .auth-card {
            background: #fff; border-radius: 24px; padding: 2.25rem 2rem;
            width: 100%; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .logo-wrap { text-align: center; margin-bottom: 1rem; }
        .logo-wrap img { height: 70px; width: auto; }
        h2 { font-family: 'Poppins', sans-serif; font-size: 1.25rem; color: #232323; text-align: center; margin-bottom: .5rem; }
        p.desc { color: #777; font-size: .9rem; text-align: center; margin-bottom: 1.5rem; line-height: 1.5; }
        label { display: block; font-size: .82rem; color: #666; font-weight: 600; margin-bottom: .3rem; }
        .mgc-input {
            width: 100%; padding: .7rem 1rem; border-radius: 12px;
            border: 1.5px solid #E0DAFF; background: #FAFAFA;
            color: #232323; font-family: 'League Spartan', sans-serif;
            font-size: 1rem; outline: none; transition: border-color .2s;
        }
        .mgc-input:focus { border-color: var(--accent); background: #fff; }
        .btn-primary {
            width: 100%; padding: .85rem; background: linear-gradient(90deg, #6B52D1, #896CFE);
            color: #fff; font-family: 'Poppins', sans-serif; font-weight: 700;
            font-size: 1rem; border: none; border-radius: 14px; cursor: pointer;
            margin-top: .75rem; transition: opacity .2s;
        }
        .btn-primary:hover { opacity: .9; }
        .auth-links { text-align: center; margin-top: 1.25rem; }
        .auth-links a { color: var(--accent); font-size: .88rem; text-decoration: none; font-weight: 600; }
        .error-msg { color: #e53e3e; font-size: .8rem; margin-top: .3rem; }
        .alert-success { background: #F0FFF4; border: 1px solid #9AE6B4; color: #276749; border-radius: 10px; padding: .75rem 1rem; font-size: .88rem; margin-bottom: 1rem; text-align: center; }
    </style>
</head>
<body>
<div class="auth-card">

    <div class="logo-wrap">
        <img src="{{ asset('images/logo-icon.svg') }}" alt="MyGymCoach">
    </div>

    <h2>نسيت كلمة المرور؟</h2>
    <p class="desc">أدخل بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور</p>

    @if(session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div style="margin-bottom:.75rem;">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="mgc-input" value="{{ old('email') }}" required autofocus>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary">إرسال رابط إعادة التعيين</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">← العودة لتسجيل الدخول</a>
    </div>

</div>
</body>
</html>
