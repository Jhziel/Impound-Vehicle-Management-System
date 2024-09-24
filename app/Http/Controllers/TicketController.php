<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Enforcer;
use App\Models\Ticket;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TicketController extends Controller
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
        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drivers = $this->getData(Driver::class, 'id', 'first_name', 'last_name', 'created_at', 'desc');
        $enforcers = $this->getData(Enforcer::class, 'id', 'first_name', 'last_name', 'created_at', 'desc');
        $violations = $this->getData(Violation::class, 'id', 'violation_name', 'violation_code', 'fine', 'violation_name', 'asc');
        return Inertia::render('Tickets/Create', [
            'drivers' => $drivers,
            'violations' => $violations,
            'enforcers' => $enforcers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'ticket_no' => ['required', 'unique:tickets,ticket_no'],
                'status' => ['required', 'string'],
                'location_of_incident' => ['required'],
                'date_of_incident' => ['required'],
                'driver_id' => ['required'],
                'enforcer_id' => ['required'],
                'violations' => ['required'],
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
            return redirect('/tickets')->with([
                'message' => 'Successfully Created the Ticket',
                'message_type' => 'success' // This will indicate a success
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput() // Keep input data to help the user fix errors
                ->with([
                    'message' => 'There were errors with your submission.',
                    'message_type' => 'error' // This will indicate an error
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {

        $drivers = $this->getData(Driver::class, 'id', 'first_name', 'last_name', 'created_at', 'desc');
        $enforcers = $this->getData(Enforcer::class, 'id', 'first_name', 'last_name', 'created_at', 'desc');
        $violations = $this->getData(Violation::class, 'id', 'violation_name', 'violation_code', 'fine', 'violation_name', 'asc');
        $ticket->load('violations');
        return Inertia::render('Tickets/Edit', [
            'drivers' => $drivers,
            'violations' => $violations,
            'enforcers' => $enforcers,
            'ticket' => $ticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        try {
            //code...
            $request->validate([
                'ticket_no' => [
                    'required',
                    Rule::unique('tickets', 'ticket_no')->ignore($ticket->id)
                ],
                'status' => ['required', 'string'],
                'location_of_incident' => ['required'],
                'date_of_incident' => ['required'],
                'driver_id' => ['required', 'exists:drivers,id'],
                'enforcer_id' => ['required', 'exists:enforcers,id'],
                'violations' => ['required'],
            ]);

            $ticket->update([
                'ticket_no' => $request->ticket_no,
                'driver_id' => $request->driver_id,
                'enforcer_id' => $request->enforcer_id,
                'status' => $request->status,
                'location_of_incident' => $request->location_of_incident,
                'date_of_incident' => $request->date_of_incident,
            ]);

            $ticket->violations()->sync($request->violations);
            return redirect('/tickets')->with([
                'message' => 'Successfully Updated the Ticket',
                'message_type' => 'success' // This will indicate a success
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput() // Keep input data to help the user fix errors
                ->with([
                    'message' => 'There were errors with your submission.',
                    'message_type' => 'error' // This will indicate an error
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {

        $ticket->delete();
        return redirect('/tickets')->with([
            'message' => 'Successfully Deleted the Ticket',
            'message_type' => 'success' // This will indicate a success
        ]);
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
