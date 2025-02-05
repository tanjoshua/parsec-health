<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display dashboard page.
     */
    public function index( Request $request, Tenant $tenant)
    {
        $activeVisits = $tenant->visits()
            ->whereNull('left_at')
            ->with('customer')
            ->orderBy('registered_at', 'desc')
            ->get();

        $completedVisits = $tenant->visits()
            ->whereNotNull('left_at')
            ->with('customer')
            ->orderBy('left_at', 'desc')
            ->take(11)
            ->get();

        $appointments = $tenant->appointments()->get();

        $visitId = $request->query('visit');
        $visit = $tenant->visits()->where('id', $visitId)->with('customer')->first();

        return Inertia::render('Dashboard', [
            'tenant' => $tenant,
            'activeVisits' => $activeVisits,
            'completedVisits' => $completedVisits,
            'appointments' => $appointments,
            'visit' => $visit,
        ]);
    }
}
