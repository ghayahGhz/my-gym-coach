<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\UserExercise;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private function profile(): UserProfile
    {
        return Auth::user()->profile;
    }

    public function index(Request $request)
    {
        $profile   = $this->profile();
        $days      = $profile->days ?? ['sat'];
        $activeDay = $request->query('day', $days[0] ?? 'sat');

        $exercises  = $profile->exercisesForDay($activeDay);
        $library    = Exercise::orderBy('muscle')->orderBy('name')->get()->groupBy('muscle');
        $allMuscles = Exercise::distinct()->pluck('muscle_ar', 'muscle');

        // Weekly challenge: count done sessions this week (Sat–Fri)
        $weekStart    = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd      = $weekStart->copy()->addDays(6)->endOfDay();
        $weekSessions = $profile->doneDates()
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->count();
        $weekTarget   = count($days);

        // Motivational quotes (rotate daily)
        $quotes = [
            ['ar' => 'كل تكرار يقربك من النسخة التي تريدها.', 'sub' => 'أنت أقوى مما تعتقد!'],
            ['ar' => 'الاستمرارية هي سر التغيير الحقيقي.', 'sub' => 'لا تتوقف حتى تفتخر بنفسك!'],
            ['ar' => 'جسمك يسمعك، فكن صوتاً إيجابياً له.', 'sub' => 'ابدأ اليوم، لا تنتظر الغد!'],
            ['ar' => 'كل يوم تتمرن هو يوم تكسب فيه.', 'sub' => 'الانضباط يبني الأبطال!'],
            ['ar' => 'القوة لا تأتي من الجسم فقط، بل من الإرادة.', 'sub' => 'أنت تستطيع!'],
            ['ar' => 'لا يوجد اختصار للنجاح، فقط الجهد.', 'sub' => 'استمر وستصل!'],
            ['ar' => 'كل خطوة إلى الأمام هي انتصار.', 'sub' => 'أنت على الطريق الصحيح!'],
        ];
        $quote = $quotes[now()->dayOfYear % count($quotes)];

        // Stats
        $todayDone  = $profile->doneCountForDay($activeDay);
        $todayTotal = $profile->userExercises()->where('day', $activeDay)->count();
        $streak     = $profile->streak();
        $weekDays   = count($profile->doneDates()
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->get());

        return view('home.index', compact(
            'profile', 'activeDay', 'exercises', 'library', 'allMuscles', 'days',
            'weekSessions', 'weekTarget', 'quote', 'todayDone', 'todayTotal', 'streak', 'weekDays'
        ));
    }

    public function addExercise(Request $request)
    {
        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'day'         => 'required|in:sat,sun,mon,tue,wed,thu,fri',
        ]);

        $profile  = $this->profile();
        $maxOrder = $profile->userExercises()->where('day', $request->day)->max('sort_order') ?? 0;

        $ex = UserExercise::create([
            'user_profile_id' => $profile->id,
            'exercise_id'     => $request->exercise_id,
            'day'             => $request->day,
            'sets'            => 3,
            'reps'            => 10,
            'weight'          => 0,
            'done'            => false,
            'sort_order'      => $maxOrder + 1,
        ]);

        $ex->load('exercise');

        return response()->json([
            'success'     => true,
            'exercise_id' => $ex->id,
            'name'        => $ex->exercise->name,
            'muscle_ar'   => $ex->exercise->muscle_ar,
            'is_time'     => $ex->exercise->is_time,
            'sets'        => $ex->sets,
            'reps'        => $ex->reps,
            'weight'      => $ex->weight,
            'done'        => $ex->done,
        ]);
    }

    public function removeExercise(int $id)
    {
        $ue = UserExercise::where('id', $id)
            ->where('user_profile_id', $this->profile()->id)
            ->firstOrFail();
        $ue->delete();
        return response()->json(['success' => true]);
    }

    public function toggleDone(int $id)
    {
        $ue = UserExercise::where('id', $id)
            ->where('user_profile_id', $this->profile()->id)
            ->firstOrFail();
        $ue->done = ! $ue->done;
        $ue->save();
        return response()->json(['done' => $ue->done]);
    }

    public function adjustField(Request $request, int $id)
    {
        $request->validate([
            'field' => 'required|in:sets,reps,weight',
            'delta' => 'required|numeric',
        ]);

        $ue = UserExercise::where('id', $id)
            ->where('user_profile_id', $this->profile()->id)
            ->firstOrFail();

        match ($request->field) {
            'sets'   => $ue->adjustSets((int) $request->delta),
            'reps'   => $ue->adjustReps((int) $request->delta),
            'weight' => $ue->adjustWeight((float) $request->delta),
        };

        return response()->json(['value' => $ue->{$request->field}]);
    }
}
