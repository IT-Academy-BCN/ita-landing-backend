<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CollaboratorsController extends Controller
{
    private $token;

    public function __construct()
    {
        $this->token = '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';
    }

/**
 * @OA\Get(
 *   path="/collaborators",
 *   tags={"Collaborators"},
 *   summary="User Collaborators",
 *   description="This endpoint return all the collaborators",
 *   @OA\Response(
 *     response="200",
 *     description="Collaborators details.",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         type="array",
 *         property="rows",
 *         @OA\Items(
 *           type="object",
 *           @OA\Property(
 *             property="name",
 *             type="string",
 *             example="CloudSalander"
 *           ),
 *           @OA\Property(
 *             property="photo",
 *             type="string",
 *             example="https://avatars.githubusercontent.com/u/1247767?v=4"
 *           ),
 *           @OA\Property(
 *             property="url",
 *             type="string",
 *             example="https://api.github.com/users/CloudSalander"
 *           )
 *         )
 *       )
 *     )
 *   )
 * )
 */

public function index()
{

    try {
        $allCollaborators= array_merge(
            $this->collaboratorPhp(),
            $this->collaboratorFrontedReact(),
            $this->collaboratorFrontedAngular(),
            $this->collaboratorJava(),
            $this->collaboratorNode()
        );
    
        $uniqueCollaborators = [];
        foreach ($allCollaborators as $collaborator) {
            if (!in_array($collaborator, $uniqueCollaborators)) {
                $uniqueCollaborators[] = $collaborator;
            }
        }
        return response()->json($uniqueCollaborators,200);

    } catch (Exception $e) {
        return response()->json([
        'message' => 'something went wrong'],404);
    }
}

//old index 
//     public function index($area)
// {
//     if ($area === 'php') {
//         return $this->collaboratorPhp();
//     } elseif ($area === 'react') {
//         return $this->collaboratorFrontedReact();
//     }elseif ($area === 'angular') {
//         return $this->collaboratorFrontedAngular();
//     }elseif ($area === 'java') {
//         return $this->collaboratorJava();
//     }elseif ($area === 'node') {
//         return $this->collaboratorNode();
//     }

//     return response()->json([
//         'message' => 'this area is invalid'
//     ],404);
// }

    public function collaboratorPhp(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken($this->token)->get($url.'/ita-landing-backend/collaborators?affiliation=direct');

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
        $response = Http::withToken($this->token)->get($url.'/ita-landing-frontend/collaborators?affiliation=direct');

        $data = $response->json();

        $reactCollaborators = [];
        foreach ($data as $collaborator) {
        $reactCollaborators[] = [
            'name' => $collaborator['login'],
            'photo' => $collaborator['avatar_url'],            
            'url' => $collaborator['html_url']
        ];
    }
        return $reactCollaborators;
    }

    public function collaboratorFrontedAngular(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken($this->token)->get($url.'/ita-challenges-frontend/collaborators?affiliation=direct');

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
        $response = Http::withToken($this->token)->get($url.'/ita-challenges-backend/collaborators?affiliation=direct');

        $data = $response->json();

        $javaCollaborators = [];
        foreach ($data as $collaborator) {
        $javaCollaborators[] = [
            'name' => $collaborator['login'],
            'photo' => $collaborator['avatar_url'],            
            'url' => $collaborator['html_url']
        ];
    }
        
    return $javaCollaborators;
    }

    public function collaboratorNode(){

        $url = env('URL_SERVER_API','https://api.github.com');
        $response = Http::withToken($this->token)->get($url.'/ita-wiki/collaborators?affiliation=direct');

        $data = $response->json();

        $nodeCollaborators = [];
        foreach ($data as $collaborator) {
        $nodeCollaborators[] = [
            'name' => $collaborator['login'],
            'photo' => $collaborator['avatar_url'],            
            'url' => $collaborator['html_url']
        ];
    }    
    return $nodeCollaborators;
    }
}
