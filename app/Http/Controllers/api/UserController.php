<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Rules\Dni;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Code;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ResetRequest;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

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
            
            $this->is_usedUpdated($request->code, $user->id);
            
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

    private function is_usedUpdated($code, $userId)
    {
        $code = Code::where('code', $code)->where('is_used', false)->firstOrFail();
        $code->is_used = true;
        $code->user_id = $userId; // Assign the user ID in the 'user_id' column (table:codes)
        $code->save();
    }


 public function forgetPassword(ForgetRequest $request){

    $email = $request->email;

    try{
        // check if user with such email exists
        $user= User::where('email',$email)->first();

        if(!$user){
            return response()->json(['error' => 'The email does not exist'],404);
        }

        // Generate password reset token
        $token= Str::random(10);

        // Assign password reset token to user's email in 'password_reset_token' table
        if(DB::table('password_reset_tokens')->where('email', $email)->first()) {
            DB::table('password_reset_tokens')->where('email', $email)->update([ 'token' => $token, ]);
        } else {
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token
            ]); 
        };

        //send password reset email
        Mail::to($email)->send(new ForgetPasswordMail($user->name, $token));

        // send confirmation response
        return response()->json(['message'=>'Password reset email sent out. Check your email'],200);
        

    }catch(Exception $exception){

        return response()->json(['message' => $exception->getMessage()],404);

    }

}

 public function resetPassword(ResetRequest $request){

    $token = $request->route('token');

    $passwordResets= DB::table('password_reset_tokens')->where('token', $token)->first();   
    
                    
    if(!$passwordResets){

        return response()->json([
            'error' => 'Invalid Token!'
        ],400);
    }
    /** @var User $user */
    $user= User::where('email',$passwordResets->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();
    DB::table('password_reset_tokens')->where('email', $passwordResets->email)->delete();

    return response()->json([
        'message' => 'User password reset successfully'
    ],200);

}

}
