<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tenant $tenant, Request $request)
    {
        $pageSize = $request->input('pageSize', 10);
        $visits = $tenant->visits()->with('customer')->paginate($pageSize)->withQueryString();
        return Inertia::render('Visits', [
            'tenant' => $tenant,
            'visits' => $visits,
            'pageSize' => $pageSize
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
