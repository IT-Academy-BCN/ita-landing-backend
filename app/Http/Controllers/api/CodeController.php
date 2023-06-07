<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Code;

class CodeController extends Controller
{
    /**
     * Save a new code in the database
     *
     */
    public function store()
    {
        Code::create([
            'code' => $this->generateRandomCode(),
            'is_used' => false
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
