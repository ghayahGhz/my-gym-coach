@extends('layouts.app')
@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
@section('content')

{{-- ═══ Header ═══ --}}
<div style="margin-bottom:1rem;">
    <div style="display:flex;align-items:baseline;gap:.4rem;">
        <span style="font-size:1.3rem;">📊</span>
        <h2 style="margin:0;font-size:1.3rem;font-family:'Poppins',sans-serif;">
            <span style="color:var(--muted);font-weight:400;">تتبع</span> <span style="color:var(--accent);">التقدم</span>
        </h2>
    </div>
    <p style="color:var(--muted);font-size:.82rem;margin:.15rem 0 0;">إحصائياتك الكاملة</p>
</div>

{{-- ═══ Monthly Summary Card ═══ --}}
<div class="card" style="margin-bottom:.85rem;background:linear-gradient(135deg,rgba(137,108,254,.12),var(--card));">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;">
        <div>
            <p style="color:var(--muted);font-size:.75rem;margin:0 0 .2rem;">إجمالي التمارين هذا الشهر</p>
            <div style="font-family:'Poppins',sans-serif;font-weight:900;font-size:2.5rem;color:var(--accent);line-height:1;">{{ $monthSessions }}</div>
            <div style="font-size:.8rem;color:var(--muted);margin-top:.2rem;">تمرين</div>
        </div>
        @if($monthSessions >= $monthTarget && $monthTarget > 0)
        <div style="color:#ffd700;font-size:.8rem;font-weight:700;display:flex;align-items:center;gap:.3rem;">
            🏆 أنت في أفضل مستوياتك!
        </div>
        @endif
    </div>
</div>

{{-- ═══ Weekly Bar Chart (4 weeks) ═══ --}}
<div class="card" style="margin-bottom:.85rem;">
    <p style="color:var(--muted);font-size:.75rem;margin:0 0 .75rem;font-weight:600;">الأداء الأسبوعي</p>
    <canvas id="weekChart" height="130"></canvas>
</div>

{{-- ═══ 4 Stat Rings ═══ --}}
@php
    $circumference = 2 * pi() * 34;
    $monthPct  = $monthTarget > 0  ? min(1, $monthSessions / $monthTarget) : 0;
    $weekPct   = $weekTarget > 0   ? min(1, $weekSessions  / $weekTarget)  : 0;
    $streakPct = min(1, $streak / 30);
    $timePctF  = $timePct / 100;
    $monthPctLabel = $monthTarget > 0 ? round($monthPct*100) : 0;
    $weekPctLabel  = $weekTarget  > 0 ? round($weekPct*100)  : 0;
@endphp

<p style="color:var(--muted);font-size:.75rem;font-weight:600;margin:0 0 .6rem;">إحصائياتك</p>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;margin-bottom:.85rem;">

    {{-- Streak --}}
    <div class="card" style="display:flex;align-items:center;gap:.75rem;padding:.85rem;">
        <div style="position:relative;width:56px;height:56px;flex-shrink:0;">
            <svg width="56" height="56" style="transform:rotate(-90deg);">
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="rgba(255,255,255,.07)"/>
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="#FF6B9D"
                    stroke-dasharray="{{ round(2*pi()*24,1) }}"
                    stroke-dashoffset="{{ round(2*pi()*24*(1-$streakPct),1) }}"
                    stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <span style="font-family:'Poppins',sans-serif;font-weight:900;font-size:.95rem;color:#FF6B9D;">{{ $streak }}</span>
            </div>
        </div>
        <div>
            <div style="font-size:.75rem;color:var(--muted);">🔥 السلسلة</div>
            <div style="font-weight:700;font-size:.88rem;">{{ $streak }} يوم</div>
        </div>
    </div>

    {{-- Monthly Sessions --}}
    <div class="card" style="display:flex;align-items:center;gap:.75rem;padding:.85rem;">
        <div style="position:relative;width:56px;height:56px;flex-shrink:0;">
            <svg width="56" height="56" style="transform:rotate(-90deg);">
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="rgba(255,255,255,.07)"/>
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="var(--accent)"
                    stroke-dasharray="{{ round(2*pi()*24,1) }}"
                    stroke-dashoffset="{{ round(2*pi()*24*(1-$monthPct),1) }}"
                    stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <span style="font-family:'Poppins',sans-serif;font-weight:900;font-size:.82rem;color:var(--accent);">{{ $monthPctLabel }}%</span>
            </div>
        </div>
        <div>
            <div style="font-size:.75rem;color:var(--muted);">تمارين الشهر</div>
            <div style="font-weight:700;font-size:.88rem;">{{ $monthSessions }}/{{ $monthTarget }}</div>
        </div>
    </div>

    {{-- Weekly Challenge --}}
    <div class="card" style="display:flex;align-items:center;gap:.75rem;padding:.85rem;">
        <div style="position:relative;width:56px;height:56px;flex-shrink:0;">
            <svg width="56" height="56" style="transform:rotate(-90deg);">
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="rgba(255,255,255,.07)"/>
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="var(--accent2)"
                    stroke-dasharray="{{ round(2*pi()*24,1) }}"
                    stroke-dashoffset="{{ round(2*pi()*24*(1-$weekPct),1) }}"
                    stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <span style="font-family:'Poppins',sans-serif;font-weight:900;font-size:.82rem;color:var(--accent2);">{{ $weekPctLabel }}%</span>
            </div>
        </div>
        <div>
            <div style="font-size:.75rem;color:var(--muted);">تحدي الأسبوع</div>
            <div style="font-weight:700;font-size:.88rem;">{{ $weekSessions }}/{{ $weekTarget }}</div>
        </div>
    </div>

    {{-- Workout Time --}}
    <div class="card" style="display:flex;align-items:center;gap:.75rem;padding:.85rem;">
        <div style="position:relative;width:56px;height:56px;flex-shrink:0;">
            <svg width="56" height="56" style="transform:rotate(-90deg);">
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="rgba(255,255,255,.07)"/>
                <circle cx="28" cy="28" r="24" stroke-width="4" fill="none" stroke="var(--lime)"
                    stroke-dasharray="{{ round(2*pi()*24,1) }}"
                    stroke-dashoffset="{{ round(2*pi()*24*(1-$timePctF),1) }}"
                    stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <span style="font-family:'Poppins',sans-serif;font-weight:900;font-size:.82rem;color:var(--lime);">{{ $timePct }}%</span>
            </div>
        </div>
        <div>
            <div style="font-size:.75rem;color:var(--muted);">وقت التمرين</div>
            <div style="font-weight:700;font-size:.88rem;">{{ $timeActual }} د</div>
        </div>
    </div>

</div>

{{-- ═══ Daily Tip ═══ --}}
<div class="card" style="border-right:3px solid var(--accent);">
    <p style="color:var(--muted);font-size:.72rem;margin:0 0 .3rem;font-weight:600;">💡 نصيحة اليوم</p>
    <p style="margin:0;font-size:.92rem;font-weight:600;line-height:1.5;">{{ $tip }}</p>
</div>

@push('scripts')
<script>
const accent = getComputedStyle(document.documentElement).getPropertyValue('--accent').trim();
const weekData = @json($weeklyData);

new Chart(document.getElementById('weekChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels:   weekData.map(w => w.label),
        datasets: [{
            data:            weekData.map(w => w.count),
            backgroundColor: weekData.map(w => w.isCurrent ? accent : 'rgba(255,255,255,.08)'),
            borderRadius: 10,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => c.raw + ' تمارين' } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { color: '#5C5C82', font: { family: 'League Spartan', size: 11 } } },
            y: {
                grid: { color: 'rgba(255,255,255,.04)' },
                ticks: { color: '#5C5C82', font: { family: 'League Spartan', size: 11 }, stepSize: 1 },
                beginAtZero: true,
            }
        }
    }
});
</script>
@endpush
@endsection
