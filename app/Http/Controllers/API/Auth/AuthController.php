<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ApiCredential;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    // Login method: Authenticate user and issue access and refresh tokens
    public function authenticate(AuthRequest $request)
    {

        // Check if the required data (username and password) are present in the request
        if (!$request->has('username') || !$request->has('password')) {
            return ApiResponse::error('Error', ['error' => 'username and password are required.'], 400);
        }
        // Validate the incoming request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string', 
        ]);
        $apiCredential = ApiCredential::where('username', $request->username)
        ->where('access_type', 'authenticate')
        ->first();
        // Check if the user exists in the database
        if (!$apiCredential || !Hash::check($request->password, $apiCredential->password)) {
            return ApiResponse::error('Error', ['error' => 'Invalid credentials.'], 401);
        }
        // Create Access Token
        $accessToken = $apiCredential->createToken('API Token')->plainTextToken;

        // Generate and store a refresh token
        $refreshToken = Str::random(60);
        $apiCredential->update(['refresh_token' => $refreshToken,'last_used_at'=> now()]);
        // Return response with tokens
        return ApiResponse::success('Access Token Created', [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => 3600, // 1 hour
        ], 201);
    }

    // Refresh Token method: Generate a new access token using the refresh token
    public function refreshToken(RefreshTokenRequest $request)
    {
        // Check if the refresh token is provided
        if (!$request->has('refresh_token')) {
            return ApiResponse::error('Validation Error', ['error' => 'Refresh token is required.'], 400);
        }

        // Validate the request to ensure a refresh token is provided
        $request->validate([
            'refresh_token' => 'required',
        ]);

        // Look up the user by the refresh token
        $apiCredential = apiCredential::where('refresh_token', $request->refresh_token)->first();

        if (!$apiCredential) {
            return ApiResponse::error('Invalid Error', ['error' => 'Invalid refresh token'], 401);
        }
        // Generate a new access token
        $newAccessToken = $apiCredential->createToken('API Token')->plainTextToken;
        // Return the new access token with expiration time
        return ApiResponse::success('Access Token Regenerate',[
            'access_token' => $newAccessToken,
            'expires_in' => 3600, // 1 hour
        ], 200);
        
    }
}
