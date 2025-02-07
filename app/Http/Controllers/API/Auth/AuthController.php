<?php
namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ApiCredential;

class AuthController extends Controller
{
    // Login method: Authenticate user and issue access and refresh tokens
    public function authenticate(Request $request)
    {

        // Check if the required data (username and password) are present in the request
        if (!$request->has('username') || !$request->has('password')) {
            return response()->json(['error' => 'username and password are required.'], 400);
        }
        // Validate the incoming request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string', // Or 'api_key' if you're using keys instead of passwords
        ]);
        $apiCredential = ApiCredential::where('username', $request->username)->first();
        // Check if the user exists in the database
        if (!$apiCredential || !Hash::check($request->password, $apiCredential->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        // Create Access Token
        $accessToken = $apiCredential->createToken('API Token')->plainTextToken;

        // Generate and store a refresh token
        $refreshToken = Str::random(60);
        $apiCredential->update(['refresh_token' => $refreshToken]);

        // Return response with tokens
        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => 3600, // 1 hour
        ]);
    }

    // Refresh Token method: Generate a new access token using the refresh token
    public function refreshToken(Request $request)
    {
        // Check if the refresh token is provided
        if (!$request->has('refresh_token')) {
            return response()->json(['error' => 'Refresh token is required.'], 400);
        }

        // Validate the request to ensure a refresh token is provided
        $request->validate([
            'refresh_token' => 'required',
        ]);

        // Look up the user by the refresh token
        $apiCredential = apiCredential::where('refresh_token', $request->refresh_token)->first();

        if (!$apiCredential) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }
        // Generate a new access token
        $newAccessToken = $apiCredential->createToken('API Token')->plainTextToken;
        // Return the new access token with expiration time
        return response()->json([
            'access_token' => $newAccessToken,
            'expires_in' => 3600, // 1 hour
        ]);
    }

    // Logout method: Revoke the user's current session's tokens
    public function logout(Request $request)
    {
        // Revoke all the user's tokens
        $request->user()->tokens()->delete();

        // Return success message
        return response()->json(['message' => 'Logged out successfully']);
    }
}
