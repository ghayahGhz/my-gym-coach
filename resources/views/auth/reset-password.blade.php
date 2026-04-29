<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyGymCoach — تعيين كلمة مرور جديدة</title>
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
        h2 { font-family: 'Poppins', sans-serif; font-size: 1.25rem; color: #232323; text-align: center; margin-bottom: 1.5rem; }
        label { display: block; font-size: .82rem; color: #666; font-weight: 600; margin-bottom: .3rem; }
        .field { margin-bottom: .9rem; }
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
            background: none; border: none; cursor: pointer; color: #999;
        }
        .btn-primary {
            width: 100%; padding: .85rem; background: linear-gradient(90deg, #6B52D1, #896CFE);
            color: #fff; font-family: 'Poppins', sans-serif; font-weight: 700;
            font-size: 1rem; border: none; border-radius: 14px; cursor: pointer;
            margin-top: .5rem; transition: opacity .2s;
        }
        .btn-primary:hover { opacity: .9; }
        .error-msg { color: #e53e3e; font-size: .8rem; margin-top: .3rem; }
    </style>
</head>
<body>
<div class="auth-card">

    <div class="logo-wrap">
        <img src="{{ asset('images/logo-icon.svg') }}" alt="MyGymCoach">
    </div>

    <h2>تعيين كلمة مرور جديدة</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="mgc-input" value="{{ old('email') }}" required autofocus>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label>كلمة المرور الجديدة</label>
            <div class="input-wrap">
                <input type="password" name="password" id="password" class="mgc-input" required>
                <button type="button" class="eye-btn" onclick="togglePwd('password')">👁</button>
            </div>
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label>تأكيد كلمة المرور</label>
            <div class="input-wrap">
                <input type="password" name="password_confirmation" id="password2" class="mgc-input" required>
                <button type="button" class="eye-btn" onclick="togglePwd('password2')">👁</button>
            </div>
        </div>

        <button type="submit" class="btn-primary">تغيير كلمة المرور</button>
    </form>

</div>
<script>
function togglePwd(id) {
    const p = document.getElementById(id);
    p.type = p.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
