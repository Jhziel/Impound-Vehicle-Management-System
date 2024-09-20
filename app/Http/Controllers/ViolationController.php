<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Violation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(4)->withQueryString();
        return Inertia::render('Violations/Index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Violations/Create');
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
    public function show(Violation $violation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Violation $violation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Violation $violation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Violation $violation)
    {
        //
    }
}
