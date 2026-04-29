@extends('layouts.app')
@section('content')

{{-- ═══ Profile Card ═══ --}}
<div class="card" style="margin-bottom:.85rem;background:linear-gradient(135deg,rgba(137,108,254,.12) 0%,var(--card) 100%);border:1px solid rgba(137,108,254,.2);">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;">
        {{-- Avatar --}}
        <div style="width:52px;height:52px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:1.4rem;font-weight:900;color:#232323;font-family:'Poppins',sans-serif;flex-shrink:0;">
            {{ mb_substr($profile->name, 0, 1) }}
        </div>
        {{-- Info --}}
        <div style="flex:1;min-width:0;">
            <h2 style="margin:0;font-size:1.1rem;font-family:'Poppins',sans-serif;">{{ $profile->name }}</h2>
            <p style="margin:.1rem 0 0;font-size:.78rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->email }}</p>
            <p style="margin:.1rem 0 0;font-size:.78rem;color:var(--muted);">{{ $profile->weight }} كجم · {{ $profile->height }} سم</p>
        </div>
        {{-- Session Badge --}}
        <div style="text-align:center;background:rgba(137,108,254,.15);border-radius:12px;padding:.5rem .75rem;flex-shrink:0;">
            <div style="font-size:1.3rem;font-weight:900;color:var(--accent);font-family:'Poppins',sans-serif;line-height:1;">{{ $profile->session_dur }}</div>
            <div style="font-size:.65rem;color:var(--muted);">دقيقة</div>
        </div>
    </div>
</div>

{{-- ═══ Day Tabs ═══ --}}
@php
    $dayLabels = ['sat'=>'السبت','sun'=>'الأحد','mon'=>'الاثنين','tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس','fri'=>'الجمعة'];
@endphp
<div style="display:flex;gap:.4rem;overflow-x:auto;padding-bottom:.25rem;margin-bottom:.85rem;" class="no-scrollbar">
    @foreach($days as $day)
    @php
        $dayExCount  = $profile->userExercises()->where('day', $day)->count();
        $dayDoneCount = $profile->userExercises()->where('day', $day)->where('done', true)->count();
        $topMuscle   = $profile->userExercises()->where('day', $day)->with('exercise')
                        ->get()->groupBy('exercise.muscle_ar')->sortByDesc(fn($g) => $g->count())->keys()->first();
        $dayLabel    = $topMuscle ?? 'حر';
        $isDayDone   = $dayExCount > 0 && $dayDoneCount === $dayExCount;
    @endphp
    <a href="{{ route('home', ['day' => $day]) }}"
       style="text-decoration:none;flex-shrink:0;display:flex;flex-direction:column;align-items:center;gap:.15rem;padding:.5rem .85rem;border-radius:14px;border:1.5px solid {{ $activeDay === $day ? 'var(--accent)' : 'rgba(255,255,255,.08)' }};background:{{ $activeDay === $day ? 'var(--accent)' : 'transparent' }};color:{{ $activeDay === $day ? '#232323' : 'var(--txt)' }};transition:all .2s;">
        <span style="font-family:'Poppins',sans-serif;font-weight:700;font-size:.85rem;">{{ $dayLabels[$day] ?? $day }}</span>
        <span style="font-size:.7rem;opacity:.8;">{{ $isDayDone ? '⚡' : '⊙' }} {{ $dayLabel }}</span>
    </a>
    @endforeach
</div>

{{-- ═══ Progress Bar ═══ --}}
@php
    $total    = $exercises->count();
    $done     = $exercises->where('done', true)->count();
    $progress = $total > 0 ? round($done / $total * 100) : 0;
@endphp
<div class="card" style="margin-bottom:.85rem;padding:.85rem 1rem;">
    <div style="display:flex;justify-content:space-between;font-size:.82rem;margin-bottom:.5rem;">
        <span style="color:var(--muted);">تقدم اليوم</span>
        <span style="color:var(--accent);font-weight:700;">{{ $done }}/{{ $total }}</span>
    </div>
    <div style="background:rgba(255,255,255,.07);border-radius:20px;height:7px;overflow:hidden;">
        <div style="height:100%;width:{{ $progress }}%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:20px;transition:width .5s;"></div>
    </div>
</div>

{{-- ═══ Stats Row ═══ --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;margin-bottom:.85rem;">
    <div class="card" style="padding:.7rem;text-align:center;">
        <div style="font-size:1.5rem;font-weight:900;color:var(--accent);font-family:'Poppins',sans-serif;">{{ $todayDone }}</div>
        <div style="font-size:.72rem;color:var(--muted);margin-top:.1rem;">منجز اليوم</div>
    </div>
    <div class="card" style="padding:.7rem;text-align:center;">
        <div style="font-size:1.5rem;font-weight:900;color:var(--accent);font-family:'Poppins',sans-serif;">{{ $streak }}</div>
        <div style="font-size:.72rem;color:var(--muted);margin-top:.1rem;">🔥 سلسلة</div>
    </div>
    <div class="card" style="padding:.7rem;text-align:center;">
        <div style="font-size:1.5rem;font-weight:900;color:var(--accent);font-family:'Poppins',sans-serif;">{{ $weekDays }}</div>
        <div style="font-size:.72rem;color:var(--muted);margin-top:.1rem;">أيام/أسبوع</div>
    </div>
</div>

{{-- ═══ Session Timer ═══ --}}
<div style="background:linear-gradient(135deg,#2A2200,#1E1A00);border:1.5px solid rgba(226,241,99,.2);border-radius:18px;padding:1rem 1.15rem;margin-bottom:.85rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;">
        <div>
            <p style="color:var(--lime);font-size:.75rem;font-weight:600;margin:0 0 .25rem;">مدة الحصة</p>
            <div id="sess-display" style="font-family:'JetBrains Mono',monospace;font-size:1.6rem;font-weight:700;color:var(--lime);letter-spacing:1px;">00:00:00</div>
        </div>
        <div style="display:flex;gap:.5rem;align-items:center;">
            <button onclick="endSession()" id="sess-end-btn"
                style="display:none;padding:.5rem .9rem;border:2px solid #ff6b6b;background:rgba(255,107,107,.1);color:#ff6b6b;border-radius:10px;cursor:pointer;font-weight:600;font-size:.82rem;font-family:'Poppins',sans-serif;">
                انتهى ✓
            </button>
            <button onclick="toggleSession()" id="sess-btn"
                style="padding:.55rem 1.1rem;background:var(--lime);color:#232323;border:none;border-radius:12px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.88rem;cursor:pointer;transition:opacity .2s;">
                ابدأ الحصة
            </button>
        </div>
    </div>
</div>

{{-- ═══ Rest Timer ═══ --}}
<div class="card" style="margin-bottom:.85rem;">
    <p style="color:var(--muted);font-size:.78rem;font-weight:600;margin:0 0 .75rem;text-align:center;">مؤقت الراحة</p>
    <div style="display:flex;align-items:center;gap:1rem;">
        {{-- Ring --}}
        <div style="position:relative;width:80px;height:80px;flex-shrink:0;">
            <svg width="80" height="80" style="transform:rotate(-90deg);">
                <circle cx="40" cy="40" r="34" stroke-width="5" fill="none" stroke="rgba(255,255,255,.08)"/>
                <circle cx="40" cy="40" r="34" stroke-width="5" fill="none" stroke="var(--accent)"
                    id="rest-ring" stroke-dasharray="213.6" stroke-dashoffset="0" stroke-linecap="round"
                    style="transition:stroke-dashoffset .5s;"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <span id="rest-display" style="font-family:'JetBrains Mono',monospace;font-size:.95rem;font-weight:700;color:var(--txt);">{{ gmdate('i:s', $profile->rest_dur) }}</span>
            </div>
        </div>
        {{-- Controls --}}
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.6rem;justify-content:center;">
                <button onclick="adjustRest(-15)" class="adj-btn">−</button>
                <span id="rest-val" style="color:var(--accent);font-family:'JetBrains Mono',monospace;font-weight:600;min-width:42px;text-align:center;font-size:.95rem;">{{ $profile->rest_dur }}s</span>
                <button onclick="adjustRest(15)" class="adj-btn">+</button>
                <span style="color:var(--muted);font-size:.78rem;">ثانية</span>
            </div>
            <div style="display:flex;gap:.5rem;">
                <button onclick="resetRest()" class="adj-btn" style="flex:1;">↺</button>
                <button onclick="toggleRest()" id="rest-btn" class="btn-primary" style="flex:2;padding:.55rem;font-size:.85rem;">▶ ابدأ</button>
            </div>
        </div>
    </div>
</div>

{{-- ═══ Weekly Challenge ═══ --}}
@php $challengePct = $weekTarget > 0 ? min(100, round($weekSessions / $weekTarget * 100)) : 0; @endphp
<div class="card" style="margin-bottom:.85rem;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:.6rem;">
        <div>
            <p style="color:var(--accent);font-size:.75rem;font-weight:700;margin:0 0 .2rem;">تحدي الأسبوع</p>
            <p style="font-size:.88rem;font-weight:600;margin:0;">أكمل {{ $weekTarget }} تمارين هذا الأسبوع</p>
        </div>
        <span style="font-size:1.5rem;">🏆</span>
    </div>
    <div style="background:rgba(255,255,255,.07);border-radius:20px;height:6px;overflow:hidden;margin-bottom:.35rem;">
        <div style="height:100%;width:{{ $challengePct }}%;background:var(--accent);border-radius:20px;transition:width .5s;"></div>
    </div>
    <p style="font-size:.75rem;color:var(--muted);margin:0;">{{ $weekSessions }} من {{ $weekTarget }} تمارين</p>
</div>

{{-- ═══ Motivational Quote ═══ --}}
<div style="background:linear-gradient(135deg,rgba(137,108,254,.25),rgba(137,108,254,.1));border:1.5px solid rgba(137,108,254,.3);border-radius:18px;padding:1rem 1.15rem;margin-bottom:.85rem;display:flex;align-items:center;gap:.85rem;">
    <span style="font-size:1.75rem;flex-shrink:0;">💎</span>
    <div>
        <p style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;margin:0 0 .2rem;color:var(--txt);">{{ $quote['ar'] }}</p>
        <p style="font-size:.78rem;color:var(--accent2);margin:0;">{{ $quote['sub'] }}</p>
    </div>
</div>

{{-- ═══ Plan Suggestion Button ═══ --}}
<button onclick="openPlanModal()" style="width:100%;padding:.9rem;background:transparent;border:2px dashed rgba(137,108,254,.4);border-radius:16px;color:var(--accent2);font-family:'Poppins',sans-serif;font-weight:600;font-size:.9rem;cursor:pointer;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:border-color .2s;"
    onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='rgba(137,108,254,.4)'">
    ✏️ اقتراح خطة تمارين
</button>

{{-- ═══ Exercises Section ═══ --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
    <h3 style="margin:0;font-size:1rem;font-family:'Poppins',sans-serif;">{{ $dayLabels[$activeDay] ?? $activeDay }}</h3>
    <button onclick="openLibrary()" class="btn-primary" style="padding:.45rem .9rem;font-size:.82rem;display:flex;align-items:center;gap:.35rem;">
        <span style="font-size:1rem;font-weight:700;">+</span> أضف تمريناً
    </button>
</div>

<div id="exercise-list">
@forelse($exercises as $ue)
<div class="ex-card {{ $ue->done ? 'done-card' : '' }}" id="ex-{{ $ue->id }}" style="position:relative;">
    <div style="display:flex;gap:.6rem;">
        {{-- Left actions --}}
        <div style="display:flex;flex-direction:column;gap:.4rem;align-items:center;padding-top:.2rem;">
            @if($ue->exercise->youtube_url)
            <a href="{{ $ue->exercise->youtube_url }}" target="_blank"
               style="display:flex;align-items:center;gap:.2rem;background:rgba(255,0,0,.15);border:none;border-radius:8px;padding:.28rem .45rem;color:#ff4444;text-decoration:none;font-size:.68rem;font-weight:700;">
                ▶ فيديو
            </a>
            @endif
            <button onclick="removeExercise({{ $ue->id }})"
                style="width:30px;height:30px;border-radius:8px;border:none;background:rgba(255,107,107,.1);color:#ff6b6b;cursor:pointer;font-size:.85rem;display:flex;align-items:center;justify-content:center;">✕</button>
            <button onclick="toggleDone({{ $ue->id }})" id="done-btn-{{ $ue->id }}"
                style="width:30px;height:30px;border-radius:50%;border:2px solid {{ $ue->done ? 'var(--lime)' : 'rgba(255,255,255,.2)' }};background:{{ $ue->done ? 'var(--lime)' : 'transparent' }};color:{{ $ue->done ? '#232323' : 'var(--muted)' }};cursor:pointer;font-size:.85rem;display:flex;align-items:center;justify-content:center;transition:all .2s;margin-top:auto;">✓</button>
        </div>
        {{-- Exercise content --}}
        <div style="flex:1;min-width:0;">
            {{-- Name + tags --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;margin-bottom:.5rem;">
                <div>
                    <div style="display:flex;gap:.35rem;flex-wrap:wrap;margin-bottom:.25rem;">
                        <span class="pill" style="font-size:.68rem;">{{ $ue->exercise->muscle_ar }}</span>
                        @php
                            $catLabel = match(true) {
                                $ue->exercise->muscle === 'stretch'  => 'إطالة',
                                $ue->exercise->muscle === 'cardio'   => 'كارديو',
                                $ue->exercise->is_time               => 'وقت',
                                default                              => 'مقاومة',
                            };
                        @endphp
                        <span class="pill" style="font-size:.68rem;background:rgba(226,241,99,.08);color:rgba(226,241,99,.8);">{{ $catLabel }}</span>
                    </div>
                    <span style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.93rem;">{{ $ue->exercise->name }}</span>
                </div>
            </div>
            {{-- Adjusters --}}
            <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                <div>
                    <div style="font-size:.68rem;color:var(--muted);margin-bottom:.2rem;">جولات</div>
                    <div style="display:flex;align-items:center;gap:.25rem;">
                        <button class="adj-btn" onclick="adjust({{ $ue->id }}, 'sets', -1)">−</button>
                        <span id="sets-{{ $ue->id }}" style="font-family:'JetBrains Mono',monospace;color:var(--accent);font-weight:700;min-width:22px;text-align:center;">{{ $ue->sets }}</span>
                        <button class="adj-btn" onclick="adjust({{ $ue->id }}, 'sets', 1)">+</button>
                    </div>
                </div>
                <div>
                    <div style="font-size:.68rem;color:var(--muted);margin-bottom:.2rem;">{{ $ue->exercise->is_time ? 'ثانية' : 'تكرار' }}</div>
                    <div style="display:flex;align-items:center;gap:.25rem;">
                        <button class="adj-btn" onclick="adjust({{ $ue->id }}, 'reps', -1)">−</button>
                        <span id="reps-{{ $ue->id }}" style="font-family:'JetBrains Mono',monospace;color:var(--accent);font-weight:700;min-width:22px;text-align:center;">{{ $ue->reps }}</span>
                        <button class="adj-btn" onclick="adjust({{ $ue->id }}, 'reps', 1)">+</button>
                    </div>
                </div>
                <div>
                    <div style="font-size:.68rem;color:var(--muted);margin-bottom:.2rem;">وزن كجم</div>
                    <div style="display:flex;align-items:center;gap:.25rem;">
                        <button class="adj-btn" onclick="adjust({{ $ue->id }}, 'weight', -2.5)">−</button>
                        <span id="weight-{{ $ue->id }}" style="font-family:'JetBrains Mono',monospace;color:var(--accent);font-weight:700;min-width:28px;text-align:center;">{{ $ue->weight }}</span>
                        <button class="adj-btn" onclick="adjust({{ $ue->id }}, 'weight', 2.5)">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div style="text-align:center;padding:2.5rem 1rem;color:var(--muted);">
    <div style="font-size:3rem;margin-bottom:.75rem;">🏋️</div>
    <p style="font-family:'Poppins',sans-serif;font-weight:600;color:var(--txt);margin-bottom:.35rem;">لا توجد تمارين لهذا اليوم</p>
    <p style="font-size:.85rem;">أضف تمارين من مكتبة التمارين</p>
</div>
@endforelse
</div>

{{-- ═══ All Done Banner ═══ --}}
@php $allDoneNow = $exercises->count() > 0 && $exercises->where('done', true)->count() === $exercises->count(); @endphp
<div id="all-done-banner" style="display:{{ $allDoneNow ? 'flex' : 'none' }};align-items:center;justify-content:space-between;gap:.75rem;background:linear-gradient(135deg,rgba(226,241,99,.15),rgba(137,108,254,.1));border:1.5px solid rgba(226,241,99,.35);border-radius:18px;padding:1rem 1.15rem;margin-bottom:.85rem;">
    <div>
        <div style="font-family:'Poppins',sans-serif;font-weight:700;font-size:1rem;color:var(--lime);">🎉 أنجزت كل التمارين!</div>
        <div style="font-size:.8rem;color:var(--muted);margin-top:.2rem;">هل تريد البدء من جديد ليوم جديد؟</div>
    </div>
    <button onclick="resetDay()" style="padding:.55rem 1rem;background:var(--lime);color:#232323;border:none;border-radius:12px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.85rem;cursor:pointer;white-space:nowrap;">🔄 يوم جديد</button>
</div>

{{-- ═══ Exercise Library Modal ═══ --}}
<div id="library-modal" class="modal-overlay" style="display:none;" onclick="if(event.target===this)closeLibrary()">
    <div class="modal-sheet" onclick="event.stopPropagation()">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h3 style="margin:0;font-size:1.1rem;">📚 مكتبة التمارين</h3>
            <button onclick="closeLibrary()" style="background:transparent;border:none;color:var(--muted);font-size:1.3rem;cursor:pointer;">✕</button>
        </div>
        <input type="text" id="lib-search" class="mgc-input" placeholder="ابحث عن تمرين..." oninput="filterLibrary()" style="margin-bottom:.75rem;">
        <div style="display:flex;gap:.35rem;overflow-x:auto;padding-bottom:.4rem;margin-bottom:.75rem;" class="no-scrollbar">
            <button class="day-tab active" onclick="setMuscle('all',this)">الكل</button>
            @foreach($allMuscles as $muscle => $muscleAr)
            <button class="day-tab" onclick="setMuscle('{{ $muscle }}',this)">{{ $muscleAr }}</button>
            @endforeach
        </div>
        <div id="lib-list" style="overflow-y:auto;max-height:55vh;">
            @foreach($library as $muscle => $exGroup)
            <div class="muscle-group" data-muscle="{{ $muscle }}">
                <div style="font-size:.72rem;color:var(--accent2);font-weight:700;margin:.5rem 0 .3rem;">
                    {{ \App\Models\Exercise::$muscleLabels[$muscle] ?? $muscle }}
                </div>
                @foreach($exGroup as $ex)
                <div class="lib-item" data-muscle="{{ $ex->muscle }}" data-name="{{ $ex->name }}"
                    style="display:flex;align-items:center;justify-content:space-between;padding:.55rem .4rem;border-radius:10px;cursor:pointer;transition:background .15s;margin-bottom:.15rem;"
                    onmouseover="this.style.background='rgba(255,255,255,.05)'"
                    onmouseout="this.style.background='transparent'"
                    onclick="addExercise({{ $ex->id }})">
                    <div>
                        <div style="font-weight:600;font-size:.88rem;">{{ $ex->name }}</div>
                        <div style="font-size:.72rem;color:var(--muted);">{{ $ex->muscle_ar }} · {{ $ex->is_time ? 'ثوانٍ' : 'تكرارات' }}</div>
                    </div>
                    <div style="color:var(--accent);font-size:1.3rem;font-weight:700;">+</div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ Plan Suggestion Modal ═══ --}}
<div id="plan-modal" class="modal-overlay" style="display:none;" onclick="if(event.target===this)closePlanModal()">
    <div class="modal-sheet" onclick="event.stopPropagation()" style="max-height:90vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.25rem;">
            <button onclick="closePlanModal()" style="background:transparent;border:none;color:var(--muted);font-size:1.2rem;cursor:pointer;order:-1;">✕</button>
        </div>
        <h3 style="margin:0 0 .25rem;font-size:1.1rem;text-align:center;">🤖 اقتراح خطة تمارين</h3>
        <p style="color:var(--muted);font-size:.82rem;text-align:center;margin-bottom:1.25rem;">أخبرني عن هدفك وسأبني لك خطة مناسبة</p>

        {{-- Goal --}}
        <p style="color:var(--accent);font-size:.82rem;font-weight:700;margin-bottom:.5rem;">🎯 ما هو هدفك؟</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1rem;">
            @foreach([['muscle','💪','بناء عضلات'],['fat','🔥','خسارة وزن'],['strength','🏆','قوة'],['fitness','⚡','لياقة عامة']] as $g)
            <button onclick="selectPlan('goal','{{ $g[0] }}',this)"
                class="plan-opt"
                style="padding:.9rem .5rem;border-radius:14px;border:1.5px solid rgba(255,255,255,.1);background:transparent;color:var(--txt);font-family:'League Spartan',sans-serif;font-weight:600;font-size:.9rem;cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:.3rem;transition:all .2s;">
                <span style="font-size:1.5rem;">{{ $g[1] }}</span>{{ $g[2] }}
            </button>
            @endforeach
        </div>

        {{-- Level --}}
        <p style="color:var(--accent);font-size:.82rem;font-weight:700;margin-bottom:.5rem;">📊 ما هو مستواك؟</p>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem;margin-bottom:1rem;">
            @foreach([['beginner','🌱','مبتدئ'],['intermediate','⚡','متوسط'],['advanced','🔥','متقدم']] as $l)
            <button onclick="selectPlan('level','{{ $l[0] }}',this)"
                class="plan-opt"
                style="padding:.75rem .3rem;border-radius:14px;border:1.5px solid rgba(255,255,255,.1);background:transparent;color:var(--txt);font-family:'League Spartan',sans-serif;font-weight:600;font-size:.85rem;cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:.25rem;transition:all .2s;">
                <span style="font-size:1.3rem;">{{ $l[1] }}</span>{{ $l[2] }}
            </button>
            @endforeach
        </div>

        {{-- Equipment --}}
        <p style="color:var(--accent);font-size:.82rem;font-weight:700;margin-bottom:.5rem;">🏋️ ما المعدات المتاحة؟</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1rem;">
            @foreach([['home','🏠','منزل'],['gym','🏋️','جيم كامل']] as $e)
            <button onclick="selectPlan('equipment','{{ $e[0] }}',this)"
                class="plan-opt"
                style="padding:.8rem .5rem;border-radius:14px;border:1.5px solid rgba(255,255,255,.1);background:transparent;color:var(--txt);font-family:'League Spartan',sans-serif;font-weight:600;font-size:.9rem;cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:.3rem;transition:all .2s;">
                <span style="font-size:1.5rem;">{{ $e[1] }}</span>{{ $e[2] }}
            </button>
            @endforeach
        </div>

        {{-- Training System --}}
        <p style="color:var(--accent);font-size:.82rem;font-weight:700;margin-bottom:.5rem;">📋 نظام التدريب <span style="color:var(--muted);font-weight:400;">(اختياري)</span></p>
        <div style="display:flex;flex-direction:column;gap:.4rem;margin-bottom:1.25rem;">
            @foreach([['ppl','PPL – Push Pull Legs','دفع · سحب · أرجل — تدريب كل عضلة مرتين أسبوعياً','6'],['bro','Bro Split','عضلة واحدة كبيرة يومياً — حجم تدريبي عالٍ','5'],['ul','Upper Lower (UL)','علوي / سفلي — توازن ممتاز بين القوة والحجم','4'],['hybrid','Hybrid ULPPL','يجمع UL و PPL — للمستوى المتقدم','5']] as $s)
            <button onclick="selectPlan('system','{{ $s[0] }}',this)"
                class="plan-opt"
                style="padding:.75rem 1rem;border-radius:14px;border:1.5px solid rgba(255,255,255,.1);background:transparent;color:var(--txt);font-family:'League Spartan',sans-serif;cursor:pointer;text-align:right;transition:all .2s;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <div style="font-weight:700;font-size:.9rem;">{{ $s[1] }}</div>
                    <div style="font-size:.75rem;color:var(--muted);margin-top:.15rem;">{{ $s[2] }}</div>
                </div>
                <span style="background:var(--accent);color:#232323;border-radius:8px;padding:.2rem .5rem;font-size:.72rem;font-weight:700;white-space:nowrap;margin-right:.5rem;">{{ $s[3] }} أيام</span>
            </button>
            @endforeach
        </div>

        <button id="gen-plan-btn" onclick="generatePlan()" class="btn-primary" style="width:100%;padding:.9rem;">✏️ ولّد الخطة</button>
    </div>
</div>

@push('scripts')
<script>
const DAY  = '{{ $activeDay }}';
const CSRF = document.querySelector('meta[name=csrf-token]').content;

// ─── Session Timer ───────────────────────────────────────────────────────────
let sessInterval = null, sessSeconds = 0, sessRunning = false;
function toggleSession() {
    const btn    = document.getElementById('sess-btn');
    const endBtn = document.getElementById('sess-end-btn');
    if (sessRunning) {
        clearInterval(sessInterval); sessRunning = false;
        btn.textContent = 'ابدأ الحصة';
        endBtn.style.display = 'none';
    } else {
        sessInterval = setInterval(() => {
            sessSeconds++;
            const h = String(Math.floor(sessSeconds/3600)).padStart(2,'0');
            const m = String(Math.floor((sessSeconds%3600)/60)).padStart(2,'0');
            const s = String(sessSeconds%60).padStart(2,'0');
            document.getElementById('sess-display').textContent = `${h}:${m}:${s}`;
        }, 1000);
        sessRunning = true;
        btn.textContent = 'إيقاف';
        endBtn.style.display = 'block';
    }
}
function endSession() {
    clearInterval(sessInterval);
    sessRunning = false; sessSeconds = 0;
    document.getElementById('sess-display').textContent = '00:00:00';
    document.getElementById('sess-btn').textContent = 'ابدأ الحصة';
    document.getElementById('sess-end-btn').style.display = 'none';
    const today = new Date().toISOString().slice(0,10);
    fetch('/calendar/toggle', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({date: today})
    });
}

// ─── Rest Timer ──────────────────────────────────────────────────────────────
const CIRC = 213.6;
let restMax = {{ $profile->rest_dur }}, restLeft = restMax, restRunning = false, restInterval = null;

function updateRestUI() {
    const m = String(Math.floor(restLeft/60)).padStart(2,'0');
    const s = String(restLeft%60).padStart(2,'0');
    document.getElementById('rest-display').textContent = `${m}:${s}`;
    document.getElementById('rest-val').textContent = restMax + 's';
    document.getElementById('rest-ring').style.strokeDashoffset = CIRC * (1 - restLeft / restMax);
}
function adjustRest(delta) {
    clearInterval(restInterval); restRunning = false;
    document.getElementById('rest-btn').innerHTML = '▶ ابدأ';
    restMax = Math.max(15, Math.min(300, restMax + delta));
    restLeft = restMax;
    updateRestUI();
}
function resetRest() {
    clearInterval(restInterval); restRunning = false;
    restLeft = restMax;
    document.getElementById('rest-btn').innerHTML = '▶ ابدأ';
    updateRestUI();
}
function toggleRest() {
    if (restRunning) {
        clearInterval(restInterval); restRunning = false;
        document.getElementById('rest-btn').innerHTML = '▶ ابدأ';
    } else {
        if (restLeft <= 0) { restLeft = restMax; }
        restInterval = setInterval(() => {
            restLeft--;
            updateRestUI();
            if (restLeft <= 0) {
                clearInterval(restInterval); restRunning = false;
                document.getElementById('rest-btn').innerHTML = '▶ ابدأ';
                navigator.vibrate && navigator.vibrate([200,100,200,100,400]);
            }
        }, 1000);
        restRunning = true;
        document.getElementById('rest-btn').innerHTML = '⏸ إيقاف';
    }
}
updateRestUI();

// ─── All-Done Banner ─────────────────────────────────────────────────────────
function checkAllDone() {
    const cards = document.querySelectorAll('#exercise-list .ex-card');
    if (cards.length === 0) return;
    const doneCards = document.querySelectorAll('#exercise-list .ex-card.done-card');
    const banner = document.getElementById('all-done-banner');
    if (banner) banner.style.display = (doneCards.length === cards.length) ? 'flex' : 'none';
}

function resetDay() {
    fetch('/exercises/reset-day', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({day: DAY})
    }).then(r => r.json()).then(d => {
        if (d.success) location.reload();
    });
}

// ─── Exercise AJAX ───────────────────────────────────────────────────────────
function adjust(id, field, delta) {
    fetch(`/exercises/${id}/adjust`, {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({field, delta})
    }).then(r => r.json()).then(d => {
        document.getElementById(`${field}-${id}`).textContent = d.value;
    });
}

function toggleDone(id) {
    fetch(`/exercises/${id}/toggle`, {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF}
    }).then(r => r.json()).then(d => {
        const card = document.getElementById(`ex-${id}`);
        const btn  = document.getElementById(`done-btn-${id}`);
        if (d.done) {
            card.classList.add('done-card');
            btn.style.borderColor = 'var(--lime)';
            btn.style.background  = 'var(--lime)';
            btn.style.color       = '#232323';
        } else {
            card.classList.remove('done-card');
            btn.style.borderColor = 'rgba(255,255,255,.2)';
            btn.style.background  = 'transparent';
            btn.style.color       = 'var(--muted)';
        }
        const banner = document.getElementById('all-done-banner');
        if (banner) banner.style.display = d.allDone ? 'flex' : 'none';
    });
}

function removeExercise(id) {
    if (!confirm('حذف هذا التمرين؟')) return;
    fetch(`/exercises/${id}/remove`, {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF}
    })
    .then(r => {
        if (!r.ok) throw new Error(r.status);
        return r.json();
    })
    .then(d => {
        if (d.success) {
            const el = document.getElementById(`ex-${id}`);
            el.style.opacity    = '0';
            el.style.transform  = 'translateX(40px)';
            el.style.transition = 'all .3s';
            setTimeout(() => { el.remove(); checkAllDone(); }, 300);
        }
    })
    .catch(e => alert('خطأ في الحذف: ' + e.message));
}

function addExercise(exerciseId) {
    fetch('/exercises', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({exercise_id: exerciseId, day: DAY})
    })
    .then(r => {
        if (!r.ok) throw new Error('فشل الإضافة');
        return r.json();
    })
    .then(d => {
        if (d.success) { closeLibrary(); location.reload(); }
    })
    .catch(() => alert('حدث خطأ، يرجى المحاولة مجدداً'));
}

// ─── Library Modal ───────────────────────────────────────────────────────────
let activeMuscleFlt = 'all';
function openLibrary()  { document.getElementById('library-modal').style.display = 'flex'; }
function closeLibrary() { document.getElementById('library-modal').style.display = 'none'; }
function setMuscle(m, btn) {
    activeMuscleFlt = m;
    document.querySelectorAll('#library-modal .day-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filterLibrary();
}
function filterLibrary() {
    const q = document.getElementById('lib-search').value.toLowerCase();
    document.querySelectorAll('.muscle-group').forEach(g => {
        let any = false;
        g.querySelectorAll('.lib-item').forEach(item => {
            const ok = item.dataset.name.toLowerCase().includes(q) &&
                       (activeMuscleFlt === 'all' || item.dataset.muscle === activeMuscleFlt);
            item.style.display = ok ? 'flex' : 'none';
            if (ok) any = true;
        });
        g.style.display = any ? 'block' : 'none';
    });
}

// ─── Plan Modal ──────────────────────────────────────────────────────────────
const planState = { goal: null, level: null, equipment: null, system: null };

function openPlanModal()  { document.getElementById('plan-modal').style.display = 'flex'; }
function closePlanModal() { document.getElementById('plan-modal').style.display = 'none'; }

function selectPlan(key, val, btn) {
    planState[key] = val;
    btn.parentElement.querySelectorAll('.plan-opt').forEach(b => {
        b.style.borderColor = 'rgba(255,255,255,.1)';
        b.style.background  = 'transparent';
        b.style.color       = 'var(--txt)';
    });
    btn.style.borderColor = 'var(--accent)';
    btn.style.background  = 'rgba(137,108,254,.15)';
    btn.style.color       = 'var(--accent)';
}

function generatePlan() {
    if (!planState.goal || !planState.level || !planState.equipment) {
        alert('يرجى اختيار الهدف والمستوى والمعدات أولاً');
        return;
    }

    const genBtn = document.getElementById('gen-plan-btn');
    genBtn.disabled = true;
    genBtn.textContent = '⏳ جاري التوليد...';

    fetch('/exercises/plan', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify(planState)
    })
    .then(r => {
        if (!r.ok) throw new Error('فشل التوليد');
        return r.json();
    })
    .then(d => {
        if (d.success) {
            closePlanModal();
            location.reload();
        }
    })
    .catch(() => {
        genBtn.disabled = false;
        genBtn.textContent = '✏️ ولّد الخطة';
        alert('حدث خطأ، يرجى المحاولة مجدداً');
    });
}

// Check initial state on load
checkAllDone();
</script>
@endpush
@endsection
