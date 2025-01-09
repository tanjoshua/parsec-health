<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tenant $tenant, Request $request)
    {
        $search = $request->input('search');
        $pageSize = $request->input('pageSize', 10);
        $patients = $tenant->patients()
            ->when($search, function ($queryBuilder, $search) {
                $queryBuilder->where('name', 'ilike', "%{$search}%");
            })
            ->paginate($pageSize)
            ->withQueryString();

        return Inertia::render('Patients', [
            'tenant' => $tenant,
            'patients' => $patients,
            'search' => $search,
            'pageSize' => $pageSize,
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
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
