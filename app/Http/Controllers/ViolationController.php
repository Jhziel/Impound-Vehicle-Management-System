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
        $violations = Violation::query()->when($request->input('search'), function ($query, $search) {
            $query->where('violation_name', 'like', "%{$search}%")
                ->orWhere('violation_code', 'like', "%{$search}%");
        })->paginate(4)->withQueryString();
        return Inertia::render('Violations/Index', [
            'violations' => $violations,
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
        try {
            $data = $request->validate([
                'violation_name' => ['required', 'unique:violations,violation_name'],
                'violation_code' => ['required', 'unique:violations,violation_code'],
                'fine' => ['required', 'integer'],
                'violation_description' => ['required', 'string']
            ]);

            Violation::create($data);

            return redirect('/violations')->with([
                'message' =>  'Successfully Created the Violation',
                'message_type' => 'success'
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
