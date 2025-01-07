<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Get all roles
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return response()->json($roles, 200);
    }

    // Get a single role
    public function show(Role $role)
    {
        $role->load('permissions'); // Eager load permissions
        return response()->json($role, 200);
    }

    // Create a new role
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Role created successfully!',
            'role' => $role,
        ], 201);
    }

    // Update a role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Role updated successfully!',
            'role' => $role,
        ], 200);
    }

    // Delete a role
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully!'], 200);
    }

    public function assignPermission(Request $request, $role)
    {
        // Find the role by name or ID
        $role = Role::where('name', $role)->firstOrFail(); // Change to `findOrFail` if using IDs

        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $permissions = Permission::whereIn('name', $validated['permissions'])->get();

        $role->syncPermissions($permissions);

        return response()->json([
            'message' => 'Permissions assigned successfully!',
            'role' => $role->load('permissions'),
        ], 200);
    }
}
