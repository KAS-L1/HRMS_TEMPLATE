<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Get all users
    public function index()
    {
        $users = User::paginate(10); // Paginate results for better API response
        return response()->json($users, 200);
    }

    // Get a single user by ID
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    // Create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'username' => 'nullable|string|unique:users,username|max:50', // Added optional username
            'status' => 'nullable|in:Active,Inactive,Pending',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'username' => $validated['username'] ?? strtolower($validated['first_name']) . '.' . strtolower($validated['last_name']), // Generate username if not provided
            'status' => $validated['status'] ?? 'Pending',
        ]);

        return response()->json($user, 201);
    }

    // Update user details
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'username' => 'nullable|string|unique:users,username,' . $user->id . '|max:50', // Allow updating username
            'status' => 'nullable|in:Active,Inactive,Pending',
        ]);

        $user->update([
            'first_name' => $validated['first_name'] ?? $user->first_name,
            'last_name' => $validated['last_name'] ?? $user->last_name,
            'email' => $validated['email'] ?? $user->email,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
            'username' => $validated['username'] ?? $user->username,
            'status' => $validated['status'] ?? $user->status,
        ]);

        return response()->json($user, 200);
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Assign a role to a user
    public function assignRole(Request $request, $user_id)
    {
        // Validate the request
        $validated = $request->validate([
            'roles' => 'required|array', // Validate as an array
            'roles.*' => 'exists:roles,name', // Each role must exist in the roles table
        ]);

        // Find the user by user_id
        $user = User::where('user_id', $user_id)->firstOrFail();

        // Assign roles
        $user->syncRoles($validated['roles']); // Replaces any existing roles with new ones

        return response()->json([
            'message' => 'Roles assigned successfully',
            'roles' => $user->getRoleNames() // Returns the assigned roles
        ], 200);
    }



    // Remove a specific role from a user
    public function removeRole(Request $request, $userId)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->removeRole($validated['role']);

        return response()->json(['message' => 'Role removed successfully.'], 200);
    }
}
