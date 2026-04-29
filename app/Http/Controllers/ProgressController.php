<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    private function profile(): UserProfile
    {
        return Auth::user()->profile;
    }

    public function index()
    {
        $profile = $this->profile();

        // Monthly exercises count
        $monthStart    = now()->startOfMonth()->toDateString();
        $monthEnd      = now()->endOfMonth()->toDateString();
        $monthSessions = $profile->doneDates()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->count();
        // Target: 4 weeks × training days per week
        $monthTarget = count($profile->days ?? []) * 4;

        // Weekly bar chart: last 4 weeks
        $weeklyData = collect(range(3, 0))->map(function ($weeksAgo) use ($profile) {
            $start = Carbon::now()->startOfWeek(Carbon::SATURDAY)->subWeeks($weeksAgo);
            $end   = $start->copy()->addDays(6)->endOfDay();
            $count = $profile->doneDates()
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->count();
            return [
                'label'   => 'أسبوع ' . ($weeksAgo === 0 ? '1' : ($weeksAgo + 1)),
                'count'   => $count,
                'isCurrent' => $weeksAgo === 0,
            ];
        })->values();

        // Stats
        $streak       = $profile->streak();
        $totalMins    = $profile->totalMins();
        $totalSessions = $profile->doneDates()->count();

        // Weekly challenge (current week)
        $weekStart    = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd      = $weekStart->copy()->addDays(6)->endOfDay();
        $weekSessions = $profile->doneDates()
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->count();
        $weekTarget   = count($profile->days ?? []);

        // Workout time target (session_dur × monthTarget minutes)
        $timeTarget  = $profile->session_dur * $monthTarget;
        $timeActual  = $profile->session_dur * $monthSessions;
        $timePct     = $timeTarget > 0 ? min(100, round($timeActual / $timeTarget * 100)) : 0;

        // Daily tip
        $tips = [
            'زيادة الأوزان 5-10% كل أسبوعين هو مفتاح التطور 📈',
            'النوم الكافي يبني العضلات بقدر التمرين 💤',
            'الماء أهم مكمل غذائي، لا تنسَ شرب الكميات الكافية 💧',
            'البروتين هو حجر أساس بناء العضلات 🥩',
            'الراحة جزء من التدريب، لا تتجاهلها 🌿',
            'التسخين يقلل الإصابات، لا تتخطاه أبداً 🔥',
            'الاستمرارية تتفوق على الكمال، ابدأ الآن 💎',
            'سجل تقدمك دائماً لترى كيف تتطور 📊',
            'تناول وجبة خفيفة قبل التمرين بـ 30 دقيقة ⏱️',
            'التمارين المركبة تبني قوة حقيقية 🏋️',
        ];
        $tip = $tips[now()->dayOfYear % count($tips)];

        return view('progress.index', compact(
            'profile', 'weeklyData', 'streak', 'totalMins',
            'totalSessions', 'monthSessions', 'monthTarget',
            'weekSessions', 'weekTarget',
            'timeActual', 'timeTarget', 'timePct', 'tip'
        ));
    }
}
