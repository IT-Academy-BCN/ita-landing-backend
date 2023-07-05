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

        $phpCollaborators = [];
        foreach ($data as $collaborator) {
        $phpCollaborators[] = [
            'photo' => $collaborator['avatar_url'],
            'name' => $collaborator['login'],
        ];
    }
        return $phpCollaborators;

    }

    public function collaboratorFrontedReact(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-landing-frontend/collaborators');

        $data = $response->json();

        $reactCollaborators = [];
        foreach ($data as $collaborator) {
        $reactCollaborators[] = [
            'photo' => $collaborator['avatar_url'],
            'name' => $collaborator['login'],
        ];
    }

        return $reactCollaborators;

    }

    public function collaboratorFrontedAngular(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-challenges-frontend/collaborators');

        $data = $response->json();

        $angularCollaborators = [];
        foreach ($data as $collaborator) {
        $angularCollaborators[] = [
            'photo' => $collaborator['avatar_url'],
            'name' => $collaborator['login'],
        ];
    }

        return $angularCollaborators;

    }

    public function collaboratorJava(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-challenges-backend/collaborators');

        $data = $response->json();

        $javaCollaborators = [];
        foreach ($data as $collaborator) {
        $javaCollaborators[] = [
            'photo' => $collaborator['avatar_url'],
            'name' => $collaborator['login'],
        ];
    }

        return $javaCollaborators;

    }
}
