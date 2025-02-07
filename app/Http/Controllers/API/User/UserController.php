<?php
namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    // Index method to list users (optional)
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Store method to create a new user
    public function store(UserRequest $request)
    {
        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'secondary_password' => Hash::make(env('USER_SECONDARY_PASSWORD')),
            'username' => $request->email, 
            'status' => 'Active', 
            'user_type' => 'User',
        ]);
        // Return the user details in JSON format
        return ApiResponse::success('User created successfully', $user, 201);
    }

    // Show method to get a specific user by ID
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update method to update user data
    public function update(UserRequest $request, $id)
    {
        // Find user by ID
        $user = User::findOrFail($id);

        // Update user data
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password, // Update password if provided
        ]);
        // Return the updated user data
        return ApiResponse::success('User updated successfully', $user, 200);
    }

    // Destroy method to delete a user
    public function destroy($id)
    {
        // Find user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
