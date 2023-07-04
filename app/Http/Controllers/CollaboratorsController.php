<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CollaboratorsController extends Controller
{
    public function collaborator(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url);

        $data = $response->json();

        return $data;

    }
}
