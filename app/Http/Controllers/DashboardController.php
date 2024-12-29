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
        $activeVisits = $tenant->visits()
            ->whereNull('left_at')
            ->with('patient')
            ->orderBy('registered_at', 'desc')
            ->get();

        return Inertia::render('Dashboard', [
            'tenant' => $tenant,
            'activeVisits' => $activeVisits,
        ]);
    }
}
