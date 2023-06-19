<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Rules\Dni;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
/**
 * @OA\Post(
 *   path="/register",
 *   tags={"User"},
 *   summary="User Register",
 *   description="This endpoint is used to register a new user in the application.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *           example="example@example.com"
 *         ),
 *         @OA\Property(
 *           property="name",
 *           type="string",
 *           example="John Doe"
 *         ),
 *         @OA\Property(
 *           property="dni",
 *           type="string",
 *           example="12345678A"
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string",
 *           example="password123"
 *         ),
 *         @OA\Property(
 *           property="password_confirmation",
 *           type="string",
 *           example="password123"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="User created successfully."
 *   )
 * )
 */
    public function store(Request $request)
    {
        // Input validation
        try {
            $validatedData  = $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'name' => 'string|max:255',
                'dni' => ['required','unique:users',new Dni],
                'password' => 'required|string|min:8|confirmed',
            ], [
                'email.unique' => 'The email is already in use',
                'dni.unique' => 'The DNI is already in use',
                'password.confirmed' => 'The password confirmation does not match.',
            ]);

            // Create a new user.
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'dni' => strtoupper($request->dni),
                'password' => Hash::make($request->password),
                'status' => 'ACTIVE',
                'role' => 'ADMIN',
            ]);

            // Response
            return response()->json([
                'result' => [
                    'message' => 'User created succesfully.'
                ],
                'status' => true
            ]);
        } catch (ValidationException $e) {
            return response()->json(
                [
                    'result' => ['message' => $e->getMessage()], 'status' => false
                ],
            );
        }
    }
}
