@extends('layouts.app')
@section('content')

{{-- ═══ Header ═══ --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
    <h2 style="margin:0;font-size:1.35rem;">📅 التقويم</h2>
    <div style="display:flex;align-items:center;gap:.5rem;">
        <a href="{{ route('calendar', ['month' => $month - 1, 'year' => $year]) }}"
           style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.07);display:flex;align-items:center;justify-content:center;text-decoration:none;color:var(--txt);">›</a>
        <span style="font-family:'Poppins',sans-serif;font-weight:600;font-size:.95rem;min-width:90px;text-align:center;">
            {{ $arabicMonths[$month] }} {{ $year }}
        </span>
        <a href="{{ route('calendar', ['month' => $month + 1, 'year' => $year]) }}"
           style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.07);display:flex;align-items:center;justify-content:center;text-decoration:none;color:var(--txt);">‹</a>
    </div>
</div>

{{-- ═══ Calendar Grid ═══ --}}
<div class="card" style="padding:.75rem;margin-bottom:1rem;">
    {{-- Day Headers --}}
    <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:2px;margin-bottom:.4rem;">
        @foreach(['سبت','أحد','اثن','ثلا','أرب','خمي','جمع'] as $h)
        <div style="text-align:center;font-size:.7rem;color:var(--muted);font-weight:600;padding:.3rem 0;">{{ $h }}</div>
        @endforeach
    </div>
    {{-- Calendar Weeks --}}
    @foreach($grid as $week)
    <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:2px;">
        @foreach($week as $cell)
        @php
            $isToday  = $cell['isToday'];
            $isDone   = $cell['isDone'];
            $inMonth  = $cell['inMonth'];
            $date     = $cell['date'];
            $cellBg   = $isDone ? 'var(--lime)' : ($isToday ? 'rgba(137,108,254,.2)' : 'transparent');
            $textClr  = $isDone ? '#232323' : ($inMonth ? 'var(--txt)' : 'rgba(255,255,255,.2)');
            $border   = $isToday && !$isDone ? '1.5px solid var(--accent)' : ($isDone ? '1.5px solid var(--lime)' : '1.5px solid transparent');
        @endphp
        <button
            onclick="toggleDate('{{ $date }}')"
            id="cal-{{ $date }}"
            data-date="{{ $date }}"
            data-done="{{ $isDone ? '1' : '0' }}"
            style="aspect-ratio:1;border-radius:8px;border:{{ $border }};background:{{ $cellBg }};color:{{ $textClr }};font-size:.8rem;font-weight:{{ $isToday ? '700' : '500' }};cursor:pointer;font-family:'Poppins',sans-serif;transition:all .2s;display:flex;align-items:center;justify-content:center;">
            {{ $cell['day'] }}
        </button>
        @endforeach
    </div>
    @endforeach

    {{-- Legend --}}
    <div style="display:flex;gap:1rem;justify-content:center;margin-top:.75rem;font-size:.75rem;color:var(--muted);">
        <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:var(--lime);margin-left:.3rem;"></span>تمرين مكتمل</span>
        <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;border:1.5px solid var(--accent);margin-left:.3rem;"></span>اليوم</span>
    </div>
</div>

{{-- ═══ Streak Card ═══ --}}
@php $streak = $profile->streak(); @endphp
<div class="card" style="margin-bottom:1rem;border:1px solid rgba(226,241,99,.15);">
    <div style="display:flex;align-items:center;gap:1rem;">
        <div style="font-size:2.5rem;">🔥</div>
        <div>
            <div style="font-family:'Poppins',sans-serif;font-weight:900;font-size:2rem;color:var(--lime);" id="streak-count">{{ $streak }}</div>
            <div style="color:var(--muted);font-size:.85rem;">يوم متواصل</div>
        </div>
        <div style="margin-right:auto;text-align:left;">
            <div style="font-size:.8rem;color:var(--muted);">الجلسات الكلية</div>
            <div style="font-family:'Poppins',sans-serif;font-weight:700;font-size:1.25rem;color:var(--accent);">{{ $profile->doneDates()->count() }}</div>
        </div>
    </div>
</div>

{{-- ═══ Activity Log ═══ --}}
@if($activityLog->isNotEmpty())
<h3 style="font-size:1rem;margin-bottom:.5rem;color:var(--muted);">سجل النشاط</h3>
@foreach($activityLog as $entry)
<div style="display:flex;align-items:center;gap:.75rem;padding:.6rem .75rem;background:var(--card);border-radius:10px;margin-bottom:.4rem;">
    <div style="width:8px;height:8px;border-radius:50%;background:var(--lime);flex-shrink:0;"></div>
    <span style="font-size:.85rem;">{{ \Carbon\Carbon::parse($entry->date)->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}</span>
    <span style="margin-right:auto;font-size:.75rem;color:var(--muted);">{{ $profile->session_dur }} د</span>
</div>
@endforeach
@endif

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name=csrf-token]').content;

function toggleDate(date) {
    fetch('/calendar/toggle', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({date})
    })
    .then(r => r.json())
    .then(d => {
        const btn = document.getElementById('cal-' + date);
        if (d.done) {
            btn.style.background = 'var(--lime)';
            btn.style.color = '#232323';
            btn.style.borderColor = 'var(--lime)';
            btn.dataset.done = '1';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = 'var(--txt)';
            btn.style.borderColor = 'transparent';
            btn.dataset.done = '0';
        }
        // Update streak display
        if (document.getElementById('streak-count'))
            document.getElementById('streak-count').textContent = d.streak;
    });
}
</script>
@endpush
@endsection
