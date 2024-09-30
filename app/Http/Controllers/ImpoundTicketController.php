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
use Illuminate\Validation\ValidationException;
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
            'plate_no' => ['required'],
            'vehicle_type' => ['required'],
            'ownership_type' => ['required'],
            'slot' => ['required', 'exists:slots,id']
        ], [
            'violations.required' => 'Select atleast one violations',

        ]);


        // Validate the vehicle (checks if it exists and is not impounded)
        $vehicle = $this->validateVehicle($request);

        if ($vehicle instanceof \Illuminate\Http\RedirectResponse) {
            return $vehicle;  // Return the error if validation failed
        }


        $this->markSlotAsOccupied($request->slot);


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
        ImpoundTicket::create([
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

        // Get all vehicles with the same plate_no
        $vehicles = Vehicle::where('plate_no', $request->plate_no)->get();

        // Check if any vehicle is impounded
        foreach ($vehicles as $vehicle) {
            if ($vehicle->is_impounded) {
                return redirect()->back()->withInput()->with([
                    'message' => 'This vehicle has a pending ticket as it is impounded. No new tickets can be created.',
                    'message_type' => 'error'
                ]);
            }
        }


        $isPlateNoExist = Vehicle::where('plate_no', $request->plate_no)->exists();
        if ($isPlateNoExist) {
            $vehicle = Vehicle::where('plate_no', $request->plate_no)
                ->where('vehicle_type', $request->vehicle_type)
                ->where('ownership_type', $request->ownership_type)
                ->where('driver_id', $request->ownership_type)
                ->first();

            // Check if the vehicle exists
            if (!$vehicle) {
                $errors = [];

                // Check for ownership type mismatch
                $registeredOwnershipType = Vehicle::where('plate_no', $request->plate_no)->value('ownership_type');
                if ($registeredOwnershipType !== $request->ownership_type) {
                    $errors['ownership_type'] = 'The ownership type provided does not match the registered ownership for this plate number.';
                }

                // Check for vehicle type mismatch
                $registeredVehicleType = Vehicle::where('plate_no', $request->plate_no)->value('vehicle_type');
                if ($registeredVehicleType !== $request->vehicle_type) {
                    $errors['vehicle_type'] = 'The vehicle type provided does not match the registered type for this plate number.';
                }

                // Check for driver  mismatch
                $registeredDriver = Vehicle::where('plate_no', $request->plate_no)->value('driver_id');
                if ($registeredDriver !== $request->driver_id) {
                    $errors['driver_id'] = 'The driver provided does not match the registered driver for this plate number.';
                    $errors['plate_no'] = 'This vehicle does not belong to the specified driver.';
                }

                // If there are errors, redirect back with them
                if (!empty($errors)) {

                    return redirect()->back()->withErrors($errors)->withInput()->with([
                        'message' => 'Vehicle are already in the database but theres a mismatch',
                        'message_type' => 'error',
                    ]);
                }
            }
        }
    }


    private function markSlotAsOccupied($slotId)
    {
        $slot = ImpoundSlot::find($slotId); // Retrieve the slot by ID

        if ($slot) {
            $slot->is_occupied = true; // Mark the slot as occupied
            $slot->save(); // Save the changes to the database
        }
    }
}
