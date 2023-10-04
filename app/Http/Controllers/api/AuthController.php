<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    
/**
 * @OA\Post(
 *   path="/login",
 *   tags={"User"},
 *   summary="Login",
 *   description="This endpoint is used for a user to log into the app and get an access token.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="dni",
 *           type="string",
 *           example="12345678A"
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string",
 *           example="password123"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="Access token for the user."
 *   )
 * )
 */
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
                
                return response()->json(['result' => ['message' => __('auth.success'), 'access_token' => $token], 'status' => true]);
            } else {
                return response()->json(['result' => ['message' => __('auth:failed')], 'status' => false], 401);
            }
    }


}
