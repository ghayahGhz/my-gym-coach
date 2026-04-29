@extends('layouts.app')
@section('content')

<div style="display:flex;align-items:baseline;gap:.4rem;margin-bottom:1rem;">
    <span style="font-size:1.3rem;">⚙️</span>
    <h2 style="margin:0;font-size:1.3rem;font-family:'Poppins',sans-serif;">
        <span style="color:var(--muted);font-weight:400;">الإعدا</span><span style="color:var(--accent);">دات</span>
    </h2>
</div>
<p style="color:var(--muted);font-size:.82rem;margin:-0.6rem 0 1rem;">خصص تجربتك</p>

@if(session('success'))
<div style="background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.3);border-radius:12px;padding:.7rem 1rem;font-size:.88rem;color:#4ade80;margin-bottom:1rem;">{{ session('success') }}</div>
@endif

{{-- ═══ Personal Info Section ═══ --}}
<p style="font-size:.72rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.4rem;">الملف الشخصي</p>
<div class="card" style="margin-bottom:1rem;padding:0;overflow:hidden;">

    {{-- معلوماتي --}}
    <div id="section-info" style="border-bottom:1px solid rgba(255,255,255,.06);">
        <button type="button" onclick="toggleSection('info')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;color:var(--txt);cursor:pointer;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(137,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">👤</div>
                <div style="text-align:right;">
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">معلوماتي</div>
                    <div style="font-size:.75rem;color:var(--muted);">{{ $profile->name }} · {{ $profile->weight }}كجم · {{ $profile->height }}سم</div>
                </div>
            </div>
            <span style="color:var(--muted);">‹</span>
        </button>
        <div id="body-info" style="display:none;padding:0 1.15rem 1rem;">
            <form method="POST" action="{{ route('settings.update') }}" id="form-info">
                @csrf @method('PUT')
                <input type="hidden" name="gender" id="gender-val" value="{{ old('gender', $profile->gender) }}">
                <input type="hidden" name="session_dur" id="sessdur-val" value="{{ old('session_dur', $profile->session_dur) }}">
                <input type="hidden" name="rest_dur"    id="restdur-val" value="{{ old('rest_dur', $profile->rest_dur) }}">
                <input type="hidden" name="days"        value="">

                <div style="margin-bottom:.7rem;">
                    <label style="font-size:.78rem;color:var(--muted);font-weight:600;display:block;margin-bottom:.3rem;">الاسم</label>
                    <input class="mgc-input" type="text" name="name" value="{{ old('name', $profile->name) }}" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;margin-bottom:.7rem;">
                    <div>
                        <label style="font-size:.78rem;color:var(--muted);font-weight:600;display:block;margin-bottom:.3rem;">الوزن (كجم)</label>
                        <input class="mgc-input" type="number" name="weight" value="{{ old('weight', $profile->weight) }}" min="20" max="300" step="0.1" required>
                    </div>
                    <div>
                        <label style="font-size:.78rem;color:var(--muted);font-weight:600;display:block;margin-bottom:.3rem;">الطول (سم)</label>
                        <input class="mgc-input" type="number" name="height" value="{{ old('height', $profile->height) }}" min="100" max="250" step="0.1" required>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- الجنس --}}
    <div id="section-gender" style="border-bottom:1px solid rgba(255,255,255,.06);">
        <button type="button" onclick="toggleSection('gender')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;color:var(--txt);cursor:pointer;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(137,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">⚧</div>
                <div style="text-align:right;">
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">الجنس</div>
                    <div style="font-size:.75rem;color:var(--muted);">{{ $profile->gender === 'female' ? 'أنثى' : 'ذكر' }}</div>
                </div>
            </div>
            <span style="color:var(--muted);">‹</span>
        </button>
        <div id="body-gender" style="display:none;padding:0 1.15rem 1rem;">
            <div style="display:flex;gap:.5rem;">
                <button type="button" id="btn-female" onclick="setGender('female')"
                    style="flex:1;padding:.7rem;border-radius:12px;border:2px solid {{ $profile->gender === 'female' ? 'var(--accent)' : 'rgba(255,255,255,.1)' }};background:{{ $profile->gender === 'female' ? 'rgba(137,108,254,.15)' : 'transparent' }};color:{{ $profile->gender === 'female' ? 'var(--accent)' : 'var(--muted)' }};font-family:'Poppins',sans-serif;font-weight:600;cursor:pointer;font-size:.9rem;">
                    ♀️ أنثى
                </button>
                <button type="button" id="btn-male" onclick="setGender('male')"
                    style="flex:1;padding:.7rem;border-radius:12px;border:2px solid {{ $profile->gender === 'male' ? '#E2F163' : 'rgba(255,255,255,.1)' }};background:{{ $profile->gender === 'male' ? 'rgba(226,241,99,.1)' : 'transparent' }};color:{{ $profile->gender === 'male' ? '#E2F163' : 'var(--muted)' }};font-family:'Poppins',sans-serif;font-weight:600;cursor:pointer;font-size:.9rem;">
                    ♂️ ذكر
                </button>
            </div>
        </div>
    </div>

    {{-- أيام التمرين --}}
    <div id="section-days" style="border-bottom:1px solid rgba(255,255,255,.06);">
        <button type="button" onclick="toggleSection('days')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;color:var(--txt);cursor:pointer;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(137,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">📅</div>
                <div style="text-align:right;">
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">أيام التمرين</div>
                    <div style="font-size:.75rem;color:var(--muted);">{{ implode('، ', array_map(fn($d) => ['sat'=>'السبت','sun'=>'الأحد','mon'=>'الاثنين','tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس','fri'=>'الجمعة'][$d] ?? $d, $profile->days ?? [])) }}</div>
                </div>
            </div>
            <span style="color:var(--muted);">‹</span>
        </button>
        <div id="body-days" style="display:none;padding:0 1.15rem 1rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.4rem;">
                @foreach(['sat'=>'السبت','sun'=>'الأحد','mon'=>'الاثنين','tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس','fri'=>'الجمعة'] as $val => $label)
                <label class="day-check-settings" style="display:flex;align-items:center;gap:.6rem;padding:.6rem .75rem;border-radius:10px;border:1.5px solid {{ in_array($val, $profile->days ?? []) ? 'var(--accent)' : 'rgba(255,255,255,.08)' }};background:{{ in_array($val, $profile->days ?? []) ? 'rgba(137,108,254,.08)' : 'transparent' }};cursor:pointer;transition:all .2s;">
                    <input type="checkbox" name="days_sel[]" value="{{ $val }}" {{ in_array($val, $profile->days ?? []) ? 'checked' : '' }}
                        onchange="updateDayStyle(this)" style="accent-color:var(--accent);width:16px;height:16px;cursor:pointer;">
                    <span style="font-size:.88rem;font-weight:600;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- مدة الحصة --}}
    <div id="section-sessdur" style="border-bottom:1px solid rgba(255,255,255,.06);">
        <button type="button" onclick="toggleSection('sessdur')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;color:var(--txt);cursor:pointer;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(137,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🕐</div>
                <div style="text-align:right;">
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">مدة الحصة</div>
                    <div style="font-size:.75rem;color:var(--muted);">{{ $profile->session_dur }} دقيقة</div>
                </div>
            </div>
            <span style="color:var(--muted);">‹</span>
        </button>
        <div id="body-sessdur" style="display:none;padding:0 1.15rem 1rem;">
            <div style="display:flex;gap:.5rem;">
                @foreach([60, 90, 120] as $dur)
                <button type="button" onclick="setSessDur({{ $dur }}, this)"
                    style="flex:1;padding:.65rem;border-radius:12px;border:1.5px solid {{ $profile->session_dur == $dur ? 'var(--accent)' : 'rgba(255,255,255,.1)' }};background:{{ $profile->session_dur == $dur ? 'rgba(137,108,254,.15)' : 'transparent' }};color:{{ $profile->session_dur == $dur ? 'var(--accent)' : 'var(--muted)' }};font-family:'Poppins',sans-serif;font-weight:600;cursor:pointer;transition:all .2s;">
                    {{ $dur }} د
                </button>
                @endforeach
            </div>
            <div style="margin-top:.75rem;">
                <label style="font-size:.78rem;color:var(--muted);font-weight:600;display:flex;justify-content:space-between;margin-bottom:.4rem;">
                    <span>مدة الراحة بين الجولات</span>
                    <span id="restdur-label" style="color:var(--accent);">{{ $profile->rest_dur }}s</span>
                </label>
                <input type="range" min="15" max="300" step="15" value="{{ $profile->rest_dur }}"
                    oninput="setRestDur(this.value)"
                    style="width:100%;accent-color:var(--accent);">
            </div>
        </div>
    </div>

    {{-- إعادة الإعدادات الأولية --}}
    <div>
        <button type="button" onclick="toggleSection('resetprofile')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;color:var(--txt);cursor:pointer;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(137,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">↺</div>
                <div style="text-align:right;">
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">إعادة الإعدادات الأولية</div>
                    <div style="font-size:.75rem;color:var(--muted);">تغيير الإعدادات من جديد</div>
                </div>
            </div>
            <span style="color:var(--muted);">‹</span>
        </button>
        <div id="body-resetprofile" style="display:none;padding:0 1.15rem 1rem;">
            <button type="submit" form="form-info" class="btn-primary" style="width:100%;padding:.75rem;margin-bottom:.5rem;">حفظ التغييرات</button>
            <p style="font-size:.73rem;color:var(--muted);text-align:center;margin:0;">سيتم تطبيق التغييرات فور الحفظ</p>
        </div>
    </div>

</div>

{{-- ═══ App Section ═══ --}}
<p style="font-size:.72rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.4rem;">التطبيق</p>
<div class="card" style="margin-bottom:1rem;padding:0;overflow:hidden;">

    {{-- Logout --}}
    <div style="border-bottom:1px solid rgba(255,255,255,.06);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;color:var(--txt);cursor:pointer;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(137,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🚪</div>
                    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">تسجيل الخروج</div>
                </div>
                <span style="color:var(--muted);">‹</span>
            </button>
        </form>
    </div>

    {{-- Reset Data --}}
    <div style="border-bottom:1px solid rgba(255,255,255,.06);">
        <form method="POST" action="{{ route('settings.reset') }}" onsubmit="return confirm('سيتم حذف جميع بيانات التدريب. هل أنت متأكد؟')">
            @csrf @method('DELETE')
            <button type="submit"
                style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;cursor:pointer;color:#ff6b6b;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(255,107,107,.1);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🗑️</div>
                    <div style="text-align:right;">
                        <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">إعادة ضبط كل شيء</div>
                        <div style="font-size:.75rem;color:var(--muted);">حذف البيانات والعودة للبداية</div>
                    </div>
                </div>
                <span style="color:var(--muted);">‹</span>
            </button>
        </form>
    </div>

    {{-- Delete Account --}}
    <div>
        <form method="POST" action="{{ route('settings.destroy') }}" onsubmit="return confirm('سيتم حذف حسابك نهائياً. هل أنت متأكد؟')">
            @csrf @method('DELETE')
            <button type="submit"
                style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1rem 1.15rem;background:transparent;border:none;cursor:pointer;color:#ff4444;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(255,68,68,.1);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">⚠️</div>
                    <div style="text-align:right;">
                        <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;">حذف الحساب</div>
                        <div style="font-size:.75rem;color:var(--muted);">حذف كل البيانات نهائياً</div>
                    </div>
                </div>
                <span style="color:var(--muted);">‹</span>
            </button>
        </form>
    </div>

</div>

<p style="text-align:center;color:var(--muted);font-size:.72rem;margin-top:.5rem;">💎 MyGymCoach v2.0 · مدربك لا يملي عليك الشروط</p>

<script>
// Accordion sections
function toggleSection(id) {
    const body = document.getElementById('body-' + id);
    if (!body) return;
    body.style.display = body.style.display === 'none' ? 'block' : 'none';
}

// Gender
function setGender(g) {
    document.getElementById('gender-val').value = g;
    const isF = g === 'female';
    document.getElementById('btn-female').style.cssText += ';border-color:' + (isF ? 'var(--accent)' : 'rgba(255,255,255,.1)') + ';background:' + (isF ? 'rgba(137,108,254,.15)' : 'transparent') + ';color:' + (isF ? 'var(--accent)' : 'var(--muted)');
    document.getElementById('btn-male').style.cssText += ';border-color:' + (!isF ? '#E2F163' : 'rgba(255,255,255,.1)') + ';background:' + (!isF ? 'rgba(226,241,99,.1)' : 'transparent') + ';color:' + (!isF ? '#E2F163' : 'var(--muted)');
}

// Session duration
function setSessDur(val, btn) {
    document.getElementById('sessdur-val').value = val;
    btn.parentElement.querySelectorAll('button').forEach(b => {
        b.style.borderColor = 'rgba(255,255,255,.1)';
        b.style.background  = 'transparent';
        b.style.color       = 'var(--muted)';
    });
    btn.style.borderColor = 'var(--accent)';
    btn.style.background  = 'rgba(137,108,254,.15)';
    btn.style.color       = 'var(--accent)';
}

// Rest duration
function setRestDur(val) {
    document.getElementById('restdur-val').value = val;
    document.getElementById('restdur-label').textContent = val + 's';
}

// Days checkbox style update + sync to hidden input
function updateDayStyle(cb) {
    const label = cb.closest('label');
    label.style.borderColor = cb.checked ? 'var(--accent)' : 'rgba(255,255,255,.08)';
    label.style.background  = cb.checked ? 'rgba(137,108,254,.08)' : 'transparent';
    syncDays();
}
function syncDays() {
    const checked = [...document.querySelectorAll('input[name="days_sel[]"]:checked')].map(c => c.value);
    // Remove existing days hidden inputs except the empty placeholder
    document.querySelectorAll('input[name="days[]"]').forEach(i => i.remove());
    const form = document.getElementById('form-info');
    checked.forEach(d => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'days[]'; inp.value = d;
        form.appendChild(inp);
    });
}
// Init days sync
syncDays();
</script>
@endsection
