<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index(Request $request)
    {


        $permissions = Permission::query()->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(4)
            ->withQueryString();
        return Inertia::render('Role-Permission/Permissions/Index', [
            'permissions' => $permissions,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Role-Permission/Permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'permission' => ['required', 'string', 'unique:permissions,name']
            ]);

            Permission::create([
                'name' => $request->permission
            ]);

            return redirect('/permissions')->with([
                'message' => 'Successfully Created Permission',
                'message_type' => 'success'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with([
                    'message' => 'There were errors with your submission.',
                    'message_type' => 'error'
                ]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return Inertia::render('Role-Permission/Permissions/Edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name']
        ]);

        $permission->update($request->all());

        return redirect('/permissions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect('/permissions');
    }
}
