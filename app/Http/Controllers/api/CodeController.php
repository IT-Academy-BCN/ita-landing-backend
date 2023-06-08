<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\MailableCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Code;

class CodeController extends Controller
{
    /**
     * Save a new code in the database
     * @return \Illuminate\Http\JsonResponse;
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
     *
     */
    public function generateRandomCode()
    {
        return Str::random(10);
    }

    /**
     * Send email with the generated code to the specified recipient
     *
     * @param string $recipient
     * @param string $code
     */
    public function sendEmail($recipient)
    {
        Mail::to($recipient)->send(new MailableCode($this->store()));

        return response()->json([
            'status' => true,
            'message' => 'Email sent successfully'
        ]);
    }


}
