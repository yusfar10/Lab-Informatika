<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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

        //berikan kondisi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //buat user, proses inpu /PUT
        $User = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        //response dalam format json jika user berhasil dibuat
        if ($User) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran user berhasil',
                'data' => $User,
            ], 201);
        }

        // jika gagal pendaftaran responnya
        return response()->json([
            'success' => false,
            'message' => 'Pendaftaran gagal dilakukan',
        ], 409);
    }
}
