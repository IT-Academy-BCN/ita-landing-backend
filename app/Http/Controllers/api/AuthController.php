<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate inputs
        $request->validate([
            'dni' => 'required',
            'password' => 'required|string',
        ]);
        // Get user's credentials
        $credentials = [
            'dni' => $request->dni,
            'password' => $request->password,
        ];
        // Verify user credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $token = $user->createToken('authToken')->accessToken;

            // Update 'last_login_at' when user login
            $user->update(['last_login_at' => now()]);

            return response()->json([
                'result' => ['message' => 'Logged in successfully!', 'access_token' => $token],
                'status' => true,
            ]);
        } else {
            return response()->json(['result' => ['message' => 'Invalid credentials'], 'status' => false], 401);
        }
    }
}
