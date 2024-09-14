<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return Inertia::render('Role-Permission/Roles/Index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Role-Permission/Roles/Create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name']
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        $role->givePermissionTo($request->permissions);

        return redirect('/roles');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
       
        return Inertia::render('Role-Permission/Roles/Edit', ['role' => $role->permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $permission)
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
    public function destroy(string $id)
    {
        //
    }
}
