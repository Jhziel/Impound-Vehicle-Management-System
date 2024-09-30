<?php

namespace App\Http\Controllers;

use App\Models\ImpoundSlot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImpoundAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slots = ImpoundSlot::all();
        return Inertia::render('ImpoundArea/Index', ['slots' => $slots]);
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
    public function show(ImpoundSlot $impoundSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImpoundSlot $impoundSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImpoundSlot $impoundSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImpoundSlot $impoundSlot)
    {
        //
    }
}
