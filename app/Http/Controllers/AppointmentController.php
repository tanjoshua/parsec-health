<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tenant $tenant, Request $request)
    {
        $pageSize = $request->input('pageSize', 10);
        $appointments = $tenant->appointments()
            ->where('end_time', '>=', Carbon::today())
            ->orderBy('start_time')
            ->paginate($pageSize)
            ->withQueryString();

        return Inertia::render("Appointments", [
            'tenant' => $tenant,
            'appointments' => $appointments,
            'pageSize' => $pageSize
        ]);
    }

    /**
     * Display appointments in calendar.
     */
    public function calendar(Tenant $tenant, Request $request)
    {
        $selectedDay = $request->input('day') ?? Carbon::today()->format('Y-m-d');
        $startOfDay = Carbon::createFromFormat('Y-m-d', $selectedDay)->startOfDay();
        $endOfDay = Carbon::createFromFormat('Y-m-d', $selectedDay)->endOfDay();

        $appointments = $tenant->appointments()
            ->where(function ($query) use ($startOfDay, $endOfDay) {
                $query->whereBetween('start_time', [$startOfDay, $endOfDay])
                    ->orWhereBetween('end_time', [$startOfDay, $endOfDay]);
            })
            ->get();

        return Inertia::render("AppointmentsCalendar", [
            'tenant' => $tenant,
            'selectedDay' => $selectedDay,
            'appointments' => $appointments,
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
    public function store(Tenant $tenant, Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'timezone' => 'required|string',
        ]);
    
        $startDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$validatedData['date']} {$validatedData['start_time']}",
            $validatedData['timezone']
        )->setTimezone('UTC');
    
        $endDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$validatedData['date']} {$validatedData['end_time']}",
            $validatedData['timezone']
        )->setTimezone('UTC');
    
        $appointment = $tenant->appointments()->create([
            'customer_name' => $validatedData['customer_name'],
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
