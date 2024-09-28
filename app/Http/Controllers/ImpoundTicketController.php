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

        // Validate the vehicle (checks if it exists and is not impounded)
        $vehicle = $this->validateVehicle($request);

        if ($vehicle instanceof \Illuminate\Http\RedirectResponse) {
            return $vehicle;  // Return the error if validation failed
        }


        $created_vehicle = Vehicle::create([
            'plate_no' => $request->plate_no,
            'vehicle_type' => $request->vehicle_type,
            'ownership_type' => $request->ownership_type,
            'driver_id' => $request->driver_id,
            'is_impounded' => True,
            'impound_date' => $request->date_of_incident
        ]);
        $ticket = Ticket::create([
            'ticket_no' => $request->ticket_no,
            'driver_id' => $request->driver_id,
            'enforcer_id' => $request->enforcer_id,
            'status' => $request->status,
            'location_of_incident' => $request->location_of_incident,
            'date_of_incident' => $request->date_of_incident,
        ]);
        $impoundTicket = ImpoundTicket::create([
            'driver_id' => $request->driver_id,
            'enforcer_id' => $request->enforcer_id,
            'vehicle_id' => $created_vehicle->id,
            'ticket_id' => $ticket->id,
            'impound_slot_id' => $request->slot
        ]);

        $ticket->violations()->sync($request->violations);



        return redirect('/impound-tickets')->with([
            'message' => 'Successfully Created the Impound Ticket',
            'message_type' => 'success' // This will indicate a success
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

    private function validateVehicle(Request $request)
    {
        // Fetch the vehicle with matching details
        $vehicle = true;

        $isPlateNoExist = Vehicle::where('plate_no', $request->plate_no)->exists();
        if ($isPlateNoExist) {
            $vehicle = Vehicle::where('plate_no', $request->plate_no)
                ->where('vehicle_type', $request->vehicle_type)
                ->where('ownership_type', $request->ownership_type)
                ->first();

            // Check if the vehicle is impounded (indicating a pending ticket)
            if ($vehicle->is_impounded) {
                return redirect()->back()->withInput()->with([
                    'message' => 'This vehicle has a pending ticket as it is impounded. No new tickets can be created.',
                    'message_type' => 'error'
                ]);
            }
        }

        // Check if the vehicle exists
        if (!$vehicle) {
            return redirect()->back()->withInput()->with([
                'message' => 'Vehicle are already in the database but theres a mismatch',
                'message_type' => 'error'
            ]);
        }



        // If validation passes, return the vehicle
        return $vehicle;
    }
}
