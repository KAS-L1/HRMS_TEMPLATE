<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Create a new permission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Permission created successfully!',
            'permission' => $permission,
        ], 201);
    }

    // Get all permissions
    public function index()
    {
        $permissions = Permission::all();

        return response()->json($permissions, 200);
    }
}
