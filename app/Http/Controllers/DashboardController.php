<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display dashboard page.
     */
    public function index(Tenant $tenant)
    {
        return Inertia::render('Dashboard', ['tenant' => $tenant]);
    }
}
