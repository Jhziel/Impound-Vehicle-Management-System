<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Enforcer;
use App\Models\ImpoundSlot;
use App\Models\ImpoundTicket;
use App\Models\Ticket;
use App\Models\Vehicle;
use App\Models\Violation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImpoundTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('ticket_no', 'like', "%{$search}%")
                    ->orWhereHas('driver', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('enforcer', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            })
            ->with(['driver', 'enforcer']) // Load driver and enforcer relationships
            ->paginate(4)
            ->withQueryString();
        return Inertia::render('ImpoundTickets/Index', [
            'tickets' => $tickets,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $slots = ImpoundSlot::orderByRaw('LEFT(slot_code, 1)')  // Sort by the side (L, R, T)
            ->orderByRaw('SUBSTRING(slot_code, 2) * 1')         // Sort by the numeric part
            ->get();
        $drivers = $this->getData(Driver::class, 'id', 'first_name', 'last_name', 'created_at', 'desc');
        $enforcers = $this->getData(Enforcer::class, 'id', 'first_name', 'last_name', 'created_at', 'desc');
        $violations = $this->getData(Violation::class, 'id', 'violation_name', 'violation_code', 'fine', 'violation_name', 'asc');
        return Inertia::render('ImpoundTickets/Create', [
            'drivers' => $drivers,
            'violations' => $violations,
            'enforcers' => $enforcers,
            'slots' => $slots
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticket_no' => ['required', 'unique:tickets,ticket_no'],
            'status' => ['required', 'string'],
            'location_of_incident' => ['required'],
            'date_of_incident' => ['required'],
            'driver_id' => ['required'],
            'enforcer_id' => ['required'],
            'violations' => ['required'],
            'plate_no' => ['required', 'unique:vehicles,plate_no'],
            'vehicle_type' => ['required'],
            'ownership_type' => ['required'],
            'slot' => ['required']
        ]);

        $ticket = Ticket::create([
            'ticket_no' => $request->ticket_no,
            'driver_id' => $request->driver_id,
            'enforcer_id' => $request->enforcer_id,
            'status' => $request->status,
            'location_of_incident' => $request->location_of_incident,
            'date_of_incident' => $request->date_of_incident,
        ]);

        $ticket->violations()->sync($request->violations);

        Vehicle::create([
            'plate_no' => $request->plate_no,
            'vehicle_type' => $request->vehicle_type,
            'ownership_type' => $request->ownership_type,
            'is_impounded' => True,
            'impound_date' => $request->date_of_incident
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ImpoundTicket $impoundTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImpoundTicket $impoundTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImpoundTicket $impoundTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImpoundTicket $impoundTicket)
    {
        //
    }

    private function getData($model, ...$columns)
    {
        $orderBy = array_splice($columns, -2, 2); // Extract the orderBy and direction values
        return $model::query()
            ->select($columns)
            ->orderBy($orderBy[0], $orderBy[1])
            ->get();
    }
}
