<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
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

        
        try{

            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token
            ]);

            //send email

            Mail::to($email)->send(new ForgetMail($token));

            return response()->json(['message'=>'check your email'],200);

        }catch(Exception $exception){

            return response()->json(['message' => $exception->getMessage()],404);

        }
 
    }
}
