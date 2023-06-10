<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Rules\Dni;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Code;

class UserController extends Controller
{
     /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
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
                'code' => 'required|exists:codes,code,is_used,0'
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
                'code' => $request->code,
            ]);
            
            $this->is_usedUpdated($request->code);
            
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

    private function is_usedUpdated ($code)
    {
        $code = Code::where('code', $code)->where('is_used', false)->firstOrFail();
        $code->is_used = true;
        $code->save();
    }
}
