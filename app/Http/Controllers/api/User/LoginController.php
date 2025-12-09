<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi: bisa menggunakan email atau username
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        // Pastikan salah satu dari email atau username disediakan
        if (!$request->has('email') && !$request->has('username')) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau username harus disediakan'
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Siapkan credentials untuk JWT attempt
        $credentials = ['password' => $request->password];
        if ($request->has('email')) {
            $credentials['email'] = $request->email;
        } elseif ($request->has('username')) {
            $credentials['username'] = $request->username;
        }

        try {
            // Attempt login dengan JWT
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email/Username atau password salah'
                ], 401);
            }

            // Get authenticated user
            $user = JWTAuth::user();

            // Jika berhasil login
            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'user'    => $user,
                'token'   => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ], 200);

        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membuat token'
            ], 500);
        }
    }
}
