<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Credential
        $credentials = $request->only('email', 'password');

        // Jika gagal login
        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Jika berhasil login
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }
}
