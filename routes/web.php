<?php

use App\Http\Controllers\TenantController;
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
        return redirect()->route('tenants.show', $tenant);
    }

    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('tenants', TenantController::class)->only(['show']);

    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');
});

require __DIR__.'/auth.php';
