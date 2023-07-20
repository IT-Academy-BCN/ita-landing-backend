<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CollaboratorsController extends Controller
{
    
/**
 * @OA\Get(
 *   path="/collaborators/{area}",
 *   tags={"Collaborators"},
 *   summary="User Collaborators",
 *   description="This endpoint is used to get persons that work on the specific project",
 *   @OA\Parameter(
 *     name="area",
 *     in="path",
 *     required=true,
 *     description="name of the area",
 *     @OA\Schema(
 *       type="string",
 *       example="landing"
 *     )
 *   ),
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

 public function index($area)
{
    if ($area === 'landing') {
        return $this->collaboratorLanding();
    } elseif ($area === 'wiki') {
        return $this->collaboratorItaWiki();
    }elseif ($area === 'challenges') {
        return $this->collaboratorItaChallenges();
    }
    return response()->json([
        'message' => 'this area is invalid'
    ],404);
}

public function collaboratorLogic($collaborator){

    $url = env('URL_SERVER_API','https://api.github.com');
    $response = Http::withToken(env('MY_TOKEN'))->get($url.$collaborator);

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

    public function uniqueCollaborators(...$arrays){

        $allCollaborators = array_merge(...$arrays);

        $uniqueCollaborators = [];
        foreach ($allCollaborators as $collaborator) {
            if (!in_array($collaborator, $uniqueCollaborators)) {
                $uniqueCollaborators[] = $collaborator;
            }
        }

        return $uniqueCollaborators;
    }

    public function collaboratorLanding(){

        $collaboratorPhp = '/ita-landing-backend/collaborators?affiliation=direct';
        $collaboratorReact= '/ita-landing-frontend/collaborators?affiliation=direct';

        $php = $this->collaboratorLogic($collaboratorPhp);
        $react =$this->collaboratorLogic($collaboratorReact);

    }

    public function collaboratorItaWiki(){

        $collaboratorWiki ='/ita-wiki/collaborators?affiliation=direct';
    
        return $this->collaboratorLogic($collaboratorWiki);

    }

    public function collaboratorItaChallenges(){

        $collaboratorAngular = '/ita-challenges-frontend/collaborators?affiliation=direct';
        $collaboratorJava = '/ita-challenges-backend/collaborators?affiliation=direct';

        $angular = $this->collaboratorLogic($collaboratorAngular);
        $java = $this->collaboratorLogic($collaboratorJava);
          
        $uniqueCollaborators = $this->uniqueCollaborators($angular,$java);

        return $uniqueCollaborators; 
    }

       
}
