<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        return response()->json([
            'success' => true,
            'code' => $code
        ]);
    }

    /**
     * Random code generated.
     *
     */
    public function generateRandomCode()
    {
        return $code = Str::random(10);
    }


}
