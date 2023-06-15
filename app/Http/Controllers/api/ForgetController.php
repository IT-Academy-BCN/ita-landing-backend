<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ResetRequest;
use App\Mail\ForgetMail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;




class ForgetController extends Controller
{
    //

    public function forgetPassword(ForgetRequest $request){

        $email = $request->email;

        if(User::where('email',$email)->doesntExist()){

            return response()->json(['error' => 'The email don\'t exist'],404);
        }

        $token= Str::random(10);

        $existingMail = DB::table('password_reset_tokens')->where('email', $email)->first();

        
        try{

            if($existingMail){

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
        ]);

    }
}