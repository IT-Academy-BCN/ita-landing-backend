<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\MailableCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
class CodeController extends Controller
{
    /**
     * Save a new code in the database
     * @return $code;
     */
    public function store()
    {
        $code = $this->generateRandomCode();

        Code::create([
            'code' => $code,
            'is_used' => false
        ]);

        return $code;
    }

    /**
     * Random code generated.
     * @return string
     */
    public function generateRandomCode()
    {
        return Str::random(10);
    }

    /**
     * Send email with the generated code to the specified recipient
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCodeByEmail(Request $request)
    {
        if (Auth::user()->role !== 'ADMIN') {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $validEmail = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validEmail->fails()) {
            return response()->json(['status' => false, 'message' => 'Invalid email', 'errors' => $validEmail->errors()], 400);

        }else{
            $emailAddress = $request->input('email');
            Mail::to($emailAddress)->send(new MailableCode($this->store()));
            return response()->json(['status' => true, 'message' => 'Email sent successfully']);
        }
    }
}