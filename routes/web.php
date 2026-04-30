<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// ─── Root redirect ───────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check() && auth()->user()->profile) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// ─── Auth (guests only) ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password',         [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password',        [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}',  [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password',         [AuthController::class, 'resetPassword'])->name('password.update');
});

// ─── Logout ──────────────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Onboarding (auth required, no profile yet) ──────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/onboarding',  [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
});

// ─── Main app (auth + profile required) ─────────────────────────────────────
Route::middleware(\App\Http\Middleware\HasProfile::class)->group(function () {

    Route::get('/home',     [HomeController::class,     'index'])->name('home');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    Route::put('/settings',    [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
    Route::delete('/reset',    [SettingsController::class, 'reset'])->name('settings.reset');

    Route::post('/calendar/toggle', [CalendarController::class, 'toggleDate'])->name('calendar.toggle');

    // Literal paths first, then wildcard paths
    Route::post('/exercises',                  [HomeController::class, 'addExercise'])->name('exercises.add');
    Route::post('/exercises/reset-day',        [HomeController::class, 'resetDay'])->name('exercises.reset-day');
    Route::post('/exercises/plan',             [HomeController::class, 'generatePlan'])->name('exercises.plan');
    Route::post('/exercises/custom',           [HomeController::class, 'storeCustomExercise'])->name('exercises.custom');
    Route::post('/exercises/{id}/remove',      [HomeController::class, 'removeExercise'])->name('exercises.remove');
    Route::post('/exercises/{id}/toggle',      [HomeController::class, 'toggleDone'])->name('exercises.toggle');
    Route::post('/exercises/{id}/adjust',      [HomeController::class, 'adjustField'])->name('exercises.adjust');

    Route::post('/push/subscribe',   [PushController::class, 'subscribe'])->name('push.subscribe');
    Route::post('/push/unsubscribe', [PushController::class, 'unsubscribe'])->name('push.unsubscribe');
    Route::post('/push/test',        [PushController::class, 'sendTest'])->name('push.test');
});
