<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CollaboratorsController extends Controller
{
    public function collaboratorPhp(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-landing-backend/collaborators');

        $data = $response->json();

        return $data;

    }

    public function collaboratorFrontedReact(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-landing-frontend/collaborators');

        $data = $response->json();

        return $data;

    }

    public function collaboratorFrontedAngular(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-challenges-frontend/collaborators');

        $data = $response->json();

        return $data;

    }

    public function collaboratorJava(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-challenges-backend/collaborators');

        $data = $response->json();

        return $data;

    }
}
