<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\RefreshTokenService;

class AuthController extends Controller
{
    protected $refreshTokenService;

    public function __construct(RefreshTokenService $refreshTokenService)
    {
        $this->refreshTokenService = $refreshTokenService;
    }

    /**
     * Login user and return JWT token
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $refreshToken = $this->refreshTokenService->generateRefreshToken($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60, // default jwt ttl (s)
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Guest login for authenticated users
     */
    public function guestLogin(Request $request)
    {
        $user = Auth::user(); // Assuming guest user is already authenticated or create one
        $token = JWTAuth::fromUser($user);
        $refreshToken = $this->refreshTokenService->generateRefreshToken($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Refresh access token using refresh token
     */
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        try {
            $newToken = $this->refreshTokenService->refreshAccessToken($refreshToken);
            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }
    }

    /**
     * Logout user and invalidate tokens
     */
    public function logout(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        if ($refreshToken) {
            $this->refreshTokenService->revokeRefreshToken($refreshToken);
        }

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
