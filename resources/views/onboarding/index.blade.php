<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyGymCoach — مرحباً بك</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=League+Spartan:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --accent: #896CFE; --accent2: #B3A0FF; --bg: #232323; --card: #2E2E2E; --txt: #EEEAFF; --muted: #5C5C82; --lime: #E2F163; }
        * { box-sizing: border-box; }
        body { background: var(--bg); color: var(--txt); font-family: 'League Spartan', sans-serif; min-height: 100dvh; margin: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem; }
        h1,h2,h3 { font-family: 'Poppins', sans-serif; }
        .logo-img { height: 120px; width: auto; display: block; margin: 0 auto .5rem; }
        .card { background: var(--card); border-radius: 20px; padding: 1.75rem; width: 100%; max-width: 420px; }
        .step-indicator { display: flex; gap: .4rem; justify-content: center; margin-bottom: 1.5rem; }
        .step-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.15); transition: background .3s, width .3s; }
        .step-dot.active { background: var(--accent); width: 24px; border-radius: 4px; }
        .step-dot.done { background: var(--accent2); }
        .step { display: none; } .step.active { display: block; }
        label { font-size: .85rem; color: var(--muted); font-weight: 600; display: block; margin-bottom: .4rem; }
        .mgc-input { background: #1A1A1A; border: 1.5px solid rgba(255,255,255,.12); border-radius: 10px; color: var(--txt); padding: .65rem .9rem; font-family: 'League Spartan', sans-serif; font-size: 1rem; width: 100%; outline: none; transition: border-color .2s; }
        .mgc-input:focus { border-color: var(--accent); }
        .btn-primary { background: var(--accent); color: #232323; font-family: 'Poppins', sans-serif; font-weight: 700; border-radius: 12px; padding: .8rem 1.5rem; border: none; cursor: pointer; width: 100%; font-size: 1rem; transition: opacity .2s; margin-top: .5rem; }
        .btn-primary:hover { opacity: .9; }
        .btn-back { background: transparent; border: 1.5px solid rgba(255,255,255,.15); color: var(--muted); font-family: 'Poppins', sans-serif; font-weight: 600; border-radius: 12px; padding: .7rem 1rem; cursor: pointer; width: 100%; font-size: .9rem; margin-top: .5rem; }
        .btn-back:hover { border-color: var(--accent); color: var(--accent); }
        .gender-btn { flex: 1; padding: 1.2rem .5rem; border-radius: 14px; border: 2px solid rgba(255,255,255,.1); background: transparent; color: var(--txt); font-family: 'Poppins', sans-serif; font-weight: 600; font-size: .95rem; cursor: pointer; transition: all .2s; display: flex; flex-direction: column; align-items: center; gap: .4rem; }
        .gender-btn .icon { font-size: 2rem; }
        .gender-btn.selected-female { border-color: #896CFE; background: rgba(137,108,254,.15); color: #896CFE; }
        .gender-btn.selected-male { border-color: #E2F163; background: rgba(226,241,99,.1); color: #E2F163; }
        .dur-btn { flex: 1; padding: .75rem .5rem; border-radius: 12px; border: 1.5px solid rgba(255,255,255,.1); background: transparent; color: var(--muted); font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; transition: all .2s; font-size: .95rem; }
        .dur-btn.selected { border-color: var(--accent); background: rgba(137,108,254,.15); color: var(--accent); }
        .day-check { display: flex; align-items: center; gap: .75rem; padding: .65rem .9rem; border-radius: 10px; border: 1.5px solid rgba(255,255,255,.08); background: transparent; cursor: pointer; margin-bottom: .4rem; transition: all .2s; }
        .day-check input[type=checkbox] { display: none; }
        .day-check .chk-box { width: 20px; height: 20px; border-radius: 6px; border: 2px solid rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; transition: all .2s; flex-shrink: 0; }
        .day-check input:checked ~ .chk-box { background: var(--accent); border-color: var(--accent); }
        .day-check input:checked ~ .chk-box::after { content: '✓'; color: #232323; font-size: .8rem; font-weight: 700; }
        .day-check:has(input:checked) { border-color: var(--accent); background: rgba(137,108,254,.08); }
        .day-check .day-name { color: var(--txt); font-weight: 600; }
        .error-msg { color: #ff6b6b; font-size: .82rem; margin-top: .25rem; }
        .range-wrap { display: flex; align-items: center; gap: .75rem; }
        input[type=range] { flex: 1; accent-color: var(--accent); height: 4px; cursor: pointer; }
        .range-val { color: var(--accent); font-family: 'JetBrains Mono', monospace; font-weight: 600; min-width: 45px; text-align: center; }
    </style>
</head>
<body>

<img src="/images/logo-full.svg" alt="MyGymCoach" class="logo-img">
<p style="color:var(--muted);text-align:center;margin-bottom:1.5rem;font-size:.9rem;">مرحباً بك في مدربك الشخصي</p>

<div class="card">
    {{-- Step indicators --}}
    <div class="step-indicator">
        @for($i = 1; $i <= 4; $i++)
        <div class="step-dot" id="dot-{{ $i }}"></div>
        @endfor
    </div>

    @if($errors->any())
    <div style="background:rgba(255,107,107,.1);border:1px solid #ff6b6b;border-radius:10px;padding:.75rem;margin-bottom:1rem;font-size:.85rem;color:#ff6b6b;">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('onboarding.store') }}" id="ob-form">
        @csrf

        {{-- STEP 1: Gender --}}
        <div class="step active" id="step-1">
            <h2 style="font-size:1.4rem;margin:0 0 .5rem;">اختري جنسك</h2>
            <p style="color:var(--muted);font-size:.9rem;margin-bottom:1.25rem;">يحدد الجنس لون تطبيقك</p>
            <div style="display:flex;gap:.75rem;">
                <button type="button" class="gender-btn {{ old('gender','female') === 'female' ? 'selected-female' : '' }}" onclick="selectGender('female', this)">
                    <span class="icon">♀️</span>
                    <span>أنثى</span>
                    <small style="color:var(--muted);font-size:.75rem;">بنفسجي</small>
                </button>
                <button type="button" class="gender-btn {{ old('gender','female') === 'male' ? 'selected-male' : '' }}" onclick="selectGender('male', this)">
                    <span class="icon">♂️</span>
                    <span>ذكر</span>
                    <small style="color:var(--muted);font-size:.75rem;">أخضر ليموني</small>
                </button>
            </div>
            <input type="hidden" name="gender" id="gender-input" value="{{ old('gender','female') }}">
            <button type="button" class="btn-primary" style="margin-top:1.25rem;" onclick="nextStep(1)">التالي →</button>
        </div>

        {{-- STEP 2: Profile Info --}}
        <div class="step" id="step-2">
            <h2 style="font-size:1.4rem;margin:0 0 1.25rem;">معلوماتك</h2>

            <div style="margin-bottom:.9rem;">
                <label>الاسم</label>
                <input class="mgc-input" type="text" name="name" value="{{ old('name') }}" placeholder="اسمك الكامل" required>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:.9rem;">
                <div>
                    <label>الوزن (كغ)</label>
                    <input class="mgc-input" type="number" name="weight" value="{{ old('weight',70) }}" min="20" max="300" step="0.5" required>
                </div>
                <div>
                    <label>الطول (سم)</label>
                    <input class="mgc-input" type="number" name="height" value="{{ old('height',170) }}" min="100" max="250" step="0.5" required>
                </div>
            </div>

            <button type="button" class="btn-primary" onclick="nextStep(2)">التالي →</button>
            <button type="button" class="btn-back" onclick="prevStep(2)">← رجوع</button>
        </div>

        {{-- STEP 3: Session & Rest Duration --}}
        <div class="step" id="step-3">
            <h2 style="font-size:1.4rem;margin:0 0 1.25rem;">مدة التمرين</h2>

            <label style="margin-bottom:.75rem;">مدة الجلسة (دقيقة)</label>
            <div style="display:flex;gap:.5rem;margin-bottom:1.25rem;">
                @foreach([60, 90, 120] as $d)
                <button type="button" class="dur-btn {{ old('session_dur','90') == $d ? 'selected' : '' }}"
                    onclick="selectDur('session_dur', {{ $d }}, this)">{{ $d }} د</button>
                @endforeach
            </div>
            <input type="hidden" name="session_dur" id="session-dur-input" value="{{ old('session_dur',90) }}">

            <label>استراحة افتراضية: <span id="rest-val" style="color:var(--accent);">{{ old('rest_dur',90) }} ث</span></label>
            <div class="range-wrap" style="margin-top:.5rem;">
                <span style="font-size:.75rem;color:var(--muted);">15</span>
                <input type="range" name="rest_dur" id="rest-range" min="15" max="300" step="15" value="{{ old('rest_dur',90) }}"
                    oninput="document.getElementById('rest-val').textContent = this.value + ' ث'">
                <span style="font-size:.75rem;color:var(--muted);">300</span>
            </div>

            <button type="button" class="btn-primary" style="margin-top:1.25rem;" onclick="nextStep(3)">التالي →</button>
            <button type="button" class="btn-back" onclick="prevStep(3)">← رجوع</button>
        </div>

        {{-- STEP 4: Training Days --}}
        <div class="step" id="step-4">
            <h2 style="font-size:1.4rem;margin:0 0 .5rem;">أيام التمرين</h2>
            <p style="color:var(--muted);font-size:.9rem;margin-bottom:1rem;">اختر أيامك الأسبوعية</p>

            @php
                $dayNames = ['sat'=>'السبت','sun'=>'الأحد','mon'=>'الاثنين','tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس','fri'=>'الجمعة'];
                $oldDays = old('days', ['sat','tue','thu']);
            @endphp
            @foreach($dayNames as $key => $label)
            <label class="day-check">
                <input type="checkbox" name="days[]" value="{{ $key }}" {{ in_array($key, $oldDays) ? 'checked' : '' }}>
                <div class="chk-box"></div>
                <span class="day-name">{{ $label }}</span>
            </label>
            @endforeach

            <button type="submit" class="btn-primary" style="margin-top:1rem;">ابدأ الآن 🚀</button>
            <button type="button" class="btn-back" onclick="prevStep(4)">← رجوع</button>
        </div>

    </form>
</div>

<script>
    let currentStep = {{ $errors->any() ? 4 : 1 }};

    function updateDots() {
        for (let i = 1; i <= 4; i++) {
            const dot = document.getElementById('dot-' + i);
            dot.className = 'step-dot';
            if (i < currentStep)  dot.classList.add('done');
            if (i === currentStep) dot.classList.add('active');
        }
    }

    function showStep(n) {
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        document.getElementById('step-' + n).classList.add('active');
        currentStep = n;
        updateDots();
    }

    function nextStep(from) {
        if (from === 2) {
            const name = document.querySelector('[name=name]').value.trim();
            if (!name) { alert('الرجاء إدخال الاسم'); return; }
        }
        showStep(from + 1);
    }

    function prevStep(from) { showStep(from - 1); }

    function selectGender(gender, btn) {
        document.getElementById('gender-input').value = gender;
        document.querySelectorAll('.gender-btn').forEach(b => {
            b.classList.remove('selected-female', 'selected-male');
        });
        btn.classList.add(gender === 'female' ? 'selected-female' : 'selected-male');
        // Update theme colors live
        document.documentElement.style.setProperty('--accent', gender === 'male' ? '#E2F163' : '#896CFE');
        document.documentElement.style.setProperty('--accent2', gender === 'male' ? '#C8D84F' : '#B3A0FF');
    }

    function selectDur(name, val, btn) {
        document.getElementById('session-dur-input').value = val;
        document.querySelectorAll('.dur-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
    }

    // Init
    updateDots();
    @if($errors->any()) showStep(4); @endif
</script>
</body>
</html>
