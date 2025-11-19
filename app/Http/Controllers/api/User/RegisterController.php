<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role'  => $request->role,
        ]);

        // BUAT TOKEN DENGAN JWT
        $token = JWTAuth::fromUser($User);

        // Generate refresh token
        $refreshTokenService = app(\App\Services\RefreshTokenService::class);
        $refreshToken = $refreshTokenService->generateRefreshToken($User);

        return response()->json([
        'success' => true,
        'message' => 'Pendaftaran user berhasil',
        'data' => $User,
        'token' => $token,
        'token_type' => 'bearer',
        'refresh_token' => $refreshToken,
    ], 201);
    }
}
