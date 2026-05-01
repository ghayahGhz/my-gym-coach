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
        $profile = $this->profile();

        // Auto-reset: reset all "done" flags at the start of a new day
        $today = now()->toDateString();
        if ($profile->done_reset_at !== $today) {
            $profile->userExercises()->update(['done' => false]);
            $profile->done_reset_at = $today;
            $profile->save();
        }

        $days      = $profile->days ?? ['sat'];
        $activeDay = $request->query('day', $days[0] ?? 'sat');

        $exercises  = $profile->exercisesForDay($activeDay);

        $library = Exercise::where(function ($q) use ($profile) {
            $q->whereNull('user_profile_id')
              ->orWhere('user_profile_id', $profile->id);
        })->orderBy('muscle')->orderBy('name')->get()->groupBy('muscle');

        $allMuscles       = Exercise::distinct()->pluck('muscle_ar', 'muscle');
        $addedExerciseIds = $profile->userExercises()->where('day', $activeDay)->pluck('exercise_id')->toArray();

        $weekStart    = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd      = $weekStart->copy()->addDays(6)->endOfDay();
        $weekSessions = $profile->doneDates()
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->count();
        $weekTarget   = count($days);

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

        $todayDone  = $profile->doneCountForDay($activeDay);
        $todayTotal = $profile->userExercises()->where('day', $activeDay)->count();
        $streak     = $profile->streak();
        $weekDays   = count($profile->doneDates()
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->get());

        return view('home.index', compact(
            'profile', 'activeDay', 'exercises', 'library', 'allMuscles', 'days',
            'weekSessions', 'weekTarget', 'quote', 'todayDone', 'todayTotal', 'streak', 'weekDays',
            'addedExerciseIds'
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
            'youtube_url' => $ex->exercise->youtube_url,
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
        $ue->done    = ! $ue->done;
        $ue->done_at = $ue->done ? now() : null;
        $ue->save();

        $profile = $this->profile();
        $total   = $profile->userExercises()->where('day', $ue->day)->count();
        $done    = $profile->userExercises()->where('day', $ue->day)->where('done', true)->count();

        return response()->json([
            'done'    => $ue->done,
            'done_at' => $ue->done_at?->format('d M'),
            'allDone' => $total > 0 && $done === $total,
        ]);
    }

    public function updateVideo(Request $request, int $id)
    {
        $request->validate(['url' => 'nullable|url|max:500']);

        $ue = UserExercise::where('id', $id)
            ->where('user_profile_id', $this->profile()->id)
            ->firstOrFail();

        $ue->exercise->update(['youtube_url' => $request->url ?: null]);

        return response()->json(['success' => true, 'url' => $ue->exercise->fresh()->youtube_url]);
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

    public function resetDay(Request $request)
    {
        $request->validate(['day' => 'required|in:sat,sun,mon,tue,wed,thu,fri']);
        $this->profile()->userExercises()->where('day', $request->day)->update(['done' => false]);
        return response()->json(['success' => true]);
    }

    public function storeCustomExercise(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'muscle'      => 'required|in:chest,back,legs,shoulder,abs,cardio,stretch',
            'category'    => 'required|in:strength,cardio,stretch',
            'is_time'     => 'boolean',
            'youtube_url' => 'nullable|url|max:255',
            'day'         => 'required|in:sat,sun,mon,tue,wed,thu,fri',
            'sets'        => 'integer|min:1|max:99',
            'reps'        => 'integer|min:1|max:999',
            'weight'      => 'numeric|min:0|max:500',
        ]);

        $profile  = $this->profile();
        $muscleAr = Exercise::$muscleLabels[$request->muscle] ?? $request->muscle;

        $ex = Exercise::create([
            'key'             => 'custom_' . $profile->id . '_' . uniqid(),
            'name'            => $request->name,
            'muscle'          => $request->muscle,
            'muscle_ar'       => $muscleAr,
            'category'        => $request->category,
            'is_time'         => $request->boolean('is_time'),
            'youtube_url'     => $request->youtube_url,
            'is_custom'       => true,
            'user_profile_id' => $profile->id,
        ]);

        $maxOrder = $profile->userExercises()->where('day', $request->day)->max('sort_order') ?? 0;

        $ue = UserExercise::create([
            'user_profile_id' => $profile->id,
            'exercise_id'     => $ex->id,
            'day'             => $request->day,
            'sets'            => $request->input('sets', 3),
            'reps'            => $request->input('reps', 10),
            'weight'          => $request->input('weight', 0),
            'done'            => false,
            'sort_order'      => $maxOrder + 1,
        ]);

        return response()->json(['success' => true]);
    }

    public function generatePlan(Request $request)
    {
        $request->validate([
            'goal'      => 'required|in:muscle,fat,strength,fitness',
            'level'     => 'required|in:beginner,intermediate,advanced',
            'equipment' => 'required|in:home,gym',
            'system'    => 'nullable|in:ppl,bro,ul,hybrid',
        ]);

        $profile  = $this->profile();
        $days     = $profile->days ?? ['sat'];
        $dayCount = count($days);

        $pools = [
            'gym' => [
                'push'     => ['bp', 'df', 'cf', 'sp', 'lr'],
                'pull'     => ['lp', 'crw', 'dl', 'puu'],
                'legs'     => ['sq', 'lpr', 'ht', 'lu', 'rdl', 'cal'],
                'chest'    => ['bp', 'df', 'pu', 'cf'],
                'back'     => ['lp', 'crw', 'dl', 'puu'],
                'shoulder' => ['sp', 'lr', 'fr'],
                'abs'      => ['cru', 'pl', 'rt', 'hlr', 'bc'],
                'upper'    => ['bp', 'lp', 'sp', 'lr', 'crw', 'df'],
                'lower'    => ['sq', 'lpr', 'ht', 'lu', 'rdl'],
                'cardio'   => ['tm', 'bh', 'scc', 'el'],
            ],
            'home' => [
                'push'     => ['pu', 'fr', 'lr'],
                'pull'     => ['puu'],
                'legs'     => ['sq', 'lu', 'ht', 'rdl', 'cal'],
                'chest'    => ['pu'],
                'back'     => ['puu'],
                'shoulder' => ['fr', 'lr'],
                'abs'      => ['cru', 'pl', 'rt', 'hlr', 'bc'],
                'upper'    => ['pu', 'puu', 'fr', 'lr', 'cru'],
                'lower'    => ['sq', 'lu', 'ht', 'rdl'],
                'cardio'   => ['ks'],
            ],
        ];

        $pool = $pools[$request->equipment];

        $patterns = [
            'ppl'    => ['push', 'pull', 'legs', 'push', 'pull', 'legs'],
            'bro'    => ['chest', 'back', 'legs', 'shoulder', 'abs'],
            'ul'     => ['upper', 'lower', 'upper', 'lower'],
            'hybrid' => ['push', 'pull', 'legs', 'upper', 'lower'],
        ];

        if ($request->system && isset($patterns[$request->system])) {
            $pattern = $patterns[$request->system];
        } else {
            $autoPatterns = [
                1 => ['upper'],
                2 => ['upper', 'lower'],
                3 => ['push', 'pull', 'legs'],
                4 => ['upper', 'lower', 'upper', 'lower'],
                5 => ['chest', 'back', 'legs', 'shoulder', 'abs'],
                6 => ['push', 'pull', 'legs', 'push', 'pull', 'legs'],
                7 => ['push', 'pull', 'legs', 'upper', 'lower', 'abs', 'legs'],
            ];
            $pattern = $autoPatterns[min(7, max(1, $dayCount))];
        }

        $levelCfg = [
            'beginner'     => [3, 3, 10],
            'intermediate' => [4, 4, 10],
            'advanced'     => [5, 5, 12],
        ];
        [$exCount, $sets, $reps] = $levelCfg[$request->level];

        if ($request->goal === 'strength') {
            $sets += 1;
            $reps  = max(5, $reps - 5);
        }

        $library  = Exercise::all()->keyBy('key');
        $dayTypes = $profile->day_types ?? [];

        // Clear existing exercises for all days
        $profile->userExercises()->delete();

        foreach ($days as $index => $day) {
            // Use user-assigned day type if set, else fall back to pattern
            $group  = $dayTypes[$day] ?? $pattern[$index % count($pattern)];
            $keys   = $pool[$group] ?? $pool['upper'];
            $picked = array_slice($keys, 0, $exCount);

            if (in_array($request->goal, ['fat', 'fitness'])) {
                $cardioKeys = $pool['cardio'];
                $cardioKey  = $cardioKeys[$index % count($cardioKeys)];
                if (! in_array($cardioKey, $picked)) {
                    $picked[] = $cardioKey;
                }
            }

            $order = 1;
            foreach ($picked as $key) {
                if (! isset($library[$key])) continue;
                UserExercise::create([
                    'user_profile_id' => $profile->id,
                    'exercise_id'     => $library[$key]->id,
                    'day'             => $day,
                    'sets'            => $sets,
                    'reps'            => $reps,
                    'weight'          => 0,
                    'done'            => false,
                    'sort_order'      => $order++,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
