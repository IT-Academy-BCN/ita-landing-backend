<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CollaboratorsController extends Controller
{

    public function index($area)
{
    if ($area === 'php') {
        return $this->collaboratorPhp();
    } elseif ($area === 'react') {
        return $this->collaboratorFrontedReact();
    }elseif ($area === 'angular') {
        return $this->collaboratorFrontedAngular();
    }elseif ($area === 'java') {
        return $this->collaboratorJava();
    }elseif ($area === 'node') {
        return $this->collaboratorNode();
    }

    // Manejar caso cuando no se proporciona una pestaña válida
    // Por ejemplo, redirigir o devolver un mensaje de error
}

    public function collaboratorPhp(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-landing-backend/collaborators');

        $data = $response->json();

        $phpCollaborators = [];
        foreach ($data as $collaborator) {
        $phpCollaborators[] = [
            'name' => $collaborator['login'],
            'photo' => $collaborator['avatar_url'],            
            'url' => $collaborator['html_url']
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
            'url' => $collaborator['html_url']
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
            'url' => $collaborator['html_url']
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
            'url' => $collaborator['html_url']
        ];
    }

        return $javaCollaborators;

    }

    public function collaboratorNode(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken('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')->get($url.'/ita-wiki/collaborators');

        $data = $response->json();

        $nodeCollaborators = [];
        foreach ($data as $collaborator) {
        $nodeCollaborators[] = [
            'photo' => $collaborator['avatar_url'],
            'name' => $collaborator['login'],
            'url' => $collaborator['html_url']
        ];
    }
        return $nodeCollaborators;

    }
}
