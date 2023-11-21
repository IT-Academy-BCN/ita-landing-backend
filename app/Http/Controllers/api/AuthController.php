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
                'password' => 'required|string'
           ]);
           
        // Get user's credentials
           $credentials = [
                'dni' => $request->dni,
                'password' => $request->password,
           ];
           
        // Verify user credentials
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->accessToken;
                
                return response()->json([
                    'result' => [
                        'message' => __('auth.success'), 'access_token' => $token
                    ],
                    'status' => true
                ]);
            } else {
                return response()->json([
                    'result' => [
                        'message' => __('auth.failed')],
                        'status' => false
                ], 401);                
            }
    }


}
