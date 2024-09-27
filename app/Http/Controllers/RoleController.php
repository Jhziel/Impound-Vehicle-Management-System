<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {

        $roles = Role::query()->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(4)
            ->withQueryString();
        return Inertia::render('Role-Permission/Roles/Index', [
            'roles' => $roles,
            'filters' => $request->only('search'),
        ]);
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
        try {
            $request->validate([
                'role' => ['required', 'string', 'unique:permissions,name'],
                'permissions' => ['required', 'array', 'min:1'],
            ]);

            $role = Role::create([
                'name' => $request->role
            ]);

            $role->givePermissionTo($request->permissions);

            return redirect('/roles')->with([
                'message' => 'Successfully Created Role',
                'message_type' => 'success'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with([
                    'message' => 'There were error in your submission',
                    'message_type' => 'error'
                ]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return Inertia::render('Role-Permission/Roles/Edit', [
            'permissions' => $permissions,
            'role' => $role,
            'rolePermissions' => $role->permissions->pluck('name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role' => ['required', 'string', 'unique:permissions,name'],
            'permissions' => ['required']
        ]);

        $role->update(['name' => $request->role]);
        $role->syncPermissions($request->permissions);

        return redirect('/roles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect('/roles');
    }
}
