<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    private function profile(): UserProfile
    {
        return Auth::user()->profile;
    }

    public function index()
    {
        $profile = $this->profile();
        $user    = Auth::user();
        return view('settings.index', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'gender'      => 'required|in:male,female',
            'weight'      => 'required|numeric|min:20|max:300',
            'height'      => 'required|numeric|min:100|max:250',
            'session_dur' => 'required|in:60,90,120',
            'rest_dur'    => 'required|integer|min:15|max:300',
            'days'        => 'required|array|min:1',
            'days.*'      => 'in:sat,sun,mon,tue,wed,thu,fri',
            'day_types'   => 'nullable|array',
            'day_types.*' => 'nullable|in:chest,back,legs,shoulder,abs,push,pull,upper,lower,cardio,full',
        ]);

        // Keep only types for selected days
        $types = [];
        foreach ($validated['days'] as $day) {
            $t = $request->input("day_types.{$day}");
            if ($t) $types[$day] = $t;
        }
        $validated['day_types'] = $types ?: null;

        $this->profile()->update($validated);

        return redirect()->route('settings')->with('success', 'تم حفظ الإعدادات بنجاح ✓');
    }

    public function reset()
    {
        $profile = $this->profile();
        $profile->userExercises()->delete();
        $profile->doneDates()->delete();

        return redirect()->route('home')->with('success', 'تم مسح جميع بيانات التدريب');
    }

    public function destroy()
    {
        $profile = $this->profile();
        $profile->delete();

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
