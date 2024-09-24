<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Enforcer;
use App\Models\Ticket;
use App\Models\Violation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::query()->when($request->input('search'), function ($query, $search) {
            $query->where('ticket_no', 'like', "%{$search}%");
        })->with(['driver', 'enforcer'])
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
        $drivers = Driver::query()
            ->select('id', 'first_name', 'last_name')
            ->orderBy('created_at', 'desc')
            ->get();
        $enforcers = Enforcer::query()
            ->select('id', 'first_name', 'last_name')
            ->orderBy('created_at', 'desc')
            ->get();

        $violations = Violation::query()
            ->select('id', 'violation_name', 'violation_code', 'fine')
            ->orderBy('violation_name', 'asc')
            ->get();
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
            //code...
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
            //throw $th;
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
