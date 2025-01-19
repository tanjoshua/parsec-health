<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $tenant = Auth::user()->tenants->first();
    if ($tenant) {
        return redirect()->route('tenants.dashboard', $tenant);
    }

    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('tenants/{tenant}')->name('tenants.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::resource('tenants.patients', CustomerController::class);
    Route::resource('tenants.visits', VisitController::class);

    Route::get('tenants/{tenant}/appointments/calendar', [AppointmentController::class, 'calendar'])->name('tenants.appointments.calendar');
    Route::resource('tenants.appointments', AppointmentController::class);
});

require __DIR__.'/auth.php';
