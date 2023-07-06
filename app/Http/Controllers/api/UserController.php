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
use App\Mail\ForgetMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Mail;

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

    /**
 * @OA\Post(
 *   path="/forgetpassword",
 *   tags={"User"},
 *   summary="send email to recovery password",
 *   description="This endpoint is used send an email to a register user to reset the password.",
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
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="check your email"
 *   ),
 *   @OA\Response(
 *     response="404",
 *     description="The email don\'t exist"
 *   )
 * )
 */

 public function forgetPassword(ForgetRequest $request){

    $email = $request->email;

    $user= User::where('email',$email)->doesntExist();

    $token= Str::random(10);

    $existingMail = DB::table('password_reset_tokens')->where('email', $email)->first();

    
    try{

        if($user){
            return response()->json(['error' => 'The email don\'t exist'],404);
            
        }else if($existingMail){

            DB::table('password_reset_tokens')->where('email', $email)->update([
                'token' => $token,
               ]);

        } else {

            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token
            ]);                
        }

        //send email

        Mail::to($email)->send(new ForgetMail($token));

            return response()->json(['message'=>'check your email'],200);
        

    }catch(Exception $exception){

        return response()->json(['message' => $exception->getMessage()],404);

    }

}

    /**
 * @OA\Post(
 *   path="/resetPassword/{token}",
 *   tags={"User"},
 *   summary="User recovery password",
 *   description="This endpoint is used to update the password of the user.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="token",
 *           type="string",
 *           example="abcdefghij"
 *         ),
 *          @OA\Property(
 *           property="password",
 *           type="string",
 *           example="password"
 *         ),
 *          @OA\Property(
 *           property="password_confirm",
 *           type="string",
 *           example="password"
 *         ),        
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="success"
 *   ),
 *   @OA\Response(
 *     response="400",
 *     description="Invalid Token!"
 *   )
 * )
 */

 public function resetPassword(ResetRequest $request){

    $token = $request->token;

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

    return response()->json([
        'message' => 'success'
    ],200);

}

}
