<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->profile) {
            return redirect()->route('home');
        }

        return view('onboarding.index');
    }

    public function store(Request $request)
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
        ]);

        $validated['user_id'] = Auth::id();

        UserProfile::create($validated);

        return redirect()->route('home');
    }
}
