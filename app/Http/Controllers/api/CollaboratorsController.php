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

public function collaboratorLogic($collaborator){

    $url = env('URL_SERVER_API','https://api.github.com');
    $response = Http::withToken($this->token)->get($url.$collaborator);

    $data = $response->json();

    $allCollaborators = [];
    foreach ($data as $collaborator) {
    $allCollaborators[] = [
        'name' => $collaborator['login'],
        'photo' => $collaborator['avatar_url'],            
        'url' => $collaborator['html_url']
    ];
    }
        return $allCollaborators;

    }

    public function collaboratorPhp(){

        $collaborator = '/ita-landing-backend/collaborators?affiliation=direct';

        return $this->collaboratorLogic($collaborator);

    }

    public function collaboratorFrontedReact(){

        $collaborator= '/ita-landing-frontend/collaborators?affiliation=direct';
       
        return $this->collaboratorLogic($collaborator);
    }

    public function collaboratorFrontedAngular(){

        $collaborator = '/ita-challenges-frontend/collaborators?affiliation=direct';

        return $this->collaboratorLogic($collaborator); 
    }

    public function collaboratorJava(){
        
        $collaborator = '/ita-challenges-backend/collaborators?affiliation=direct';

        return $this->collaboratorLogic($collaborator);        
    }

    public function collaboratorNode(){

        $collaborator ='/ita-wiki/collaborators?affiliation=direct';

        return $this->collaboratorLogic($collaborator);
    }
}
