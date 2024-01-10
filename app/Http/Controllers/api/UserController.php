<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ResetRequest;
use App\Mail\ForgetPasswordMail;
use App\Models\Code;
use App\Models\User;
use App\Rules\Dni;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Input validation
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'name' => 'string|max:255',
                'dni' => ['required', 'unique:users', new Dni],
                'password' => 'required|string|min:8|confirmed',
                'code' => 'required|exists:codes,code,is_used,0'
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
                    'message' => __('auth.registered')
                ],
                'status' => true,
            ]);
        } catch (ValidationException $e) {
            return response()->json(
                [
                    'result' => ['message' => $e->getMessage()], 'status' => false,
                ],
            );
        }
    }

    private function is_usedUpdated($code, $userId)
    {
        $code = Code::where('code', $code)->where('is_used', false)->first();

        if (!$code) {
            return response()->json(['error' => __('auth.invalid_code')], 404);
        }

        $code->is_used = true;
        $code->user_id = $userId; // Assign the user ID in the 'user_id' column (table:codes)
        $code->save();
    }

    public function forgetPassword(ForgetRequest $request)
    {

        $email = $request->email;

        try {
            // check if user with such email exists
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json(['error' => 'The email does not exist'], 404);
            }

            // Generate password reset token
            $token = Str::random(10);

            // Assign password reset token to user's email in 'password_reset_token' table
            if (DB::table('password_reset_tokens')->where('email', $email)->first()) {
                DB::table('password_reset_tokens')->where('email', $email)->update(['token' => $token]);
            } else {
                DB::table('password_reset_tokens')->insert([
                    'email' => $email,
                    'token' => $token,
                ]);
            }

            // Construct the password reset URL
            $url = env('APP_URL', 'https://it-academy-landing.netlify.app') . '/reset-password/' . $token;
            //send password reset email
            Mail::to($email)->send(new ForgetPasswordMail($user->name, $url));

            // send confirmation response
            return response()->json(['message' => __('passwords.sent')], 200);
        } catch (Exception $exception) {

            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function resetPassword(ResetRequest $request)
    {

        $token = $request->route('token');

        $passwordResets = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$passwordResets) {

            return response()->json([
                'error' => __('passwords.token')
            ], 400);
        }

        /** @var User $user */
        $user = User::where('email', $passwordResets->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_reset_tokens')->where('email', $passwordResets->email)->delete();

        return response()->json([
            'message' => __('passwords.reset')
        ], 200);
    }
}
