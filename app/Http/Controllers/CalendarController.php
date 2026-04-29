<?php

namespace App\Http\Controllers;

use App\Models\DoneDate;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    private function profile(): UserProfile
    {
        return Auth::user()->profile;
    }

    public function index(Request $request)
    {
        $profile = $this->profile();
        $month   = $request->integer('month', now()->month);
        $year    = $request->integer('year',  now()->year);

        if ($month < 1)  { $month = 12; $year--; }
        if ($month > 12) { $month = 1;  $year++; }

        $firstDay = Carbon::create($year, $month, 1);

        $doneDatesAll = $profile->doneDates()
            ->orderByDesc('date')
            ->pluck('date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();

        $monthPad       = str_pad($month, 2, '0', STR_PAD_LEFT);
        $doneDatesMonth = array_filter($doneDatesAll, fn($d) => str_starts_with($d, "$year-$monthPad"));

        // 6-week grid starting Saturday
        $startOfGrid = $firstDay->copy()->startOfWeek(Carbon::SATURDAY);
        $grid = [];
        $cursor = $startOfGrid->copy();
        for ($row = 0; $row < 6; $row++) {
            $week = [];
            for ($col = 0; $col < 7; $col++) {
                $week[] = [
                    'date'    => $cursor->format('Y-m-d'),
                    'day'     => $cursor->day,
                    'inMonth' => $cursor->month === $month,
                    'isToday' => $cursor->isToday(),
                    'isDone'  => in_array($cursor->format('Y-m-d'), $doneDatesAll),
                    'isWorkout' => $profile->isWorkoutDay(strtolower(substr($cursor->englishDayOfWeek, 0, 3))),
                ];
                $cursor->addDay();
            }
            $grid[] = $week;
        }

        // Activity log (last 15 done dates) with day name
        $activityLog = $profile->doneDates()
            ->orderByDesc('date')
            ->limit(15)
            ->get()
            ->map(function ($dd) use ($profile) {
                $carbon = Carbon::parse($dd->date);
                $dayKey = strtolower(substr($carbon->englishDayOfWeek, 0, 3));
                $arabicDays = [
                    'sat' => 'السبت', 'sun' => 'الأحد', 'mon' => 'الاثنين',
                    'tue' => 'الثلاثاء', 'wed' => 'الأربعاء', 'thu' => 'الخميس', 'fri' => 'الجمعة',
                ];
                return (object)[
                    'date'      => $dd->date,
                    'dayName'   => $arabicDays[$dayKey] ?? '',
                    'dateAr'    => $carbon->locale('ar')->isoFormat('D MMMM'),
                    'sessionDur' => $profile->session_dur,
                ];
            });

        $arabicMonths = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر',
        ];

        return view('calendar.index', compact(
            'profile', 'grid', 'month', 'year',
            'activityLog', 'doneDatesAll', 'arabicMonths'
        ));
    }

    public function toggleDate(Request $request)
    {
        $request->validate(['date' => 'required|date_format:Y-m-d']);

        $profile  = $this->profile();
        $existing = $profile->doneDates()->where('date', $request->date)->first();

        if ($existing) {
            $existing->delete();
            $isDone = false;
        } else {
            DoneDate::create(['user_profile_id' => $profile->id, 'date' => $request->date]);
            $isDone = true;
        }

        return response()->json([
            'done'   => $isDone,
            'streak' => $profile->fresh()->streak(),
        ]);
    }
}
