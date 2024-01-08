<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CollaboratorsController extends Controller
{
    public function index($area)
    {
        if ($area === 'landing') {
            return $this->collaboratorLanding();
        } elseif ($area === 'wiki') {
            return $this->collaboratorItaWiki();
        } elseif ($area === 'challenges') {
            return $this->collaboratorItaChallenges();
        } elseif ($area === 'profiles') {
            return $this->collaboratorItaProfiles();
        }

        return response()->json([
            'message' => 'this area is invalid',
        ], 404);
    }

    public function collaboratorLogic($collaborator)
    {
        $url = env('URL_SERVER_API', 'https://api.github.com');
        $response = Http::withToken(env('MY_TOKEN'))->get($url.$collaborator);

        $data = $response->json();

        $allCollaborators = [];
        foreach ($data as $collaborator) {
            $allCollaborators[] = [
                'name' => $collaborator['login'],
                'photo' => $collaborator['avatar_url'],
                'url' => $collaborator['html_url'],
            ];
        }

        return $allCollaborators;
    }

    public function uniqueCollaborators(...$arrays)
    {

        $allCollaborators = array_merge(...$arrays);

        $uniqueCollaborators = [];
        foreach ($allCollaborators as $collaborator) {
            if (! in_array($collaborator, $uniqueCollaborators)) {
                $uniqueCollaborators[] = $collaborator;
            }
        }

        return $uniqueCollaborators;
    }

    public function collaboratorLanding()
    {
        $collaboratorPhp = '/ita-landing-backend/collaborators?affiliation=direct';
        $collaboratorReact = '/ita-landing-frontend/collaborators?affiliation=direct';

        $php = $this->collaboratorLogic($collaboratorPhp);
        $react = $this->collaboratorLogic($collaboratorReact);

        $uniqueCollaborators = $this->uniqueCollaborators($php, $react);

        return $uniqueCollaborators;

    }

    public function collaboratorItaWiki()
    {

        $collaboratorWiki = '/ita-wiki/collaborators?affiliation=direct';

        $wiki = $this->collaboratorLogic($collaboratorWiki);

        $uniqueCollaborators = $this->uniqueCollaborators($wiki);

        return $uniqueCollaborators;

    }

    public function collaboratorItaChallenges()
    {

        $collaboratorAngular = '/ita-challenges-frontend/collaborators?affiliation=direct';
        $collaboratorJava = '/ita-challenges-backend/collaborators?affiliation=direct';

        $angular = $this->collaboratorLogic($collaboratorAngular);
        $java = $this->collaboratorLogic($collaboratorJava);

        $uniqueCollaborators = $this->uniqueCollaborators($angular, $java);

        return $uniqueCollaborators;
    }

    public function collaboratorItaProfiles()
    {
        $collaboratorReactProfiles = '/ita-profiles-frontend/collaborators?affiliation=direct';
        $collaboratorPhpProfiles = '/ita-profiles-backend/collaborators?affiliation=direct';

        $reactProfiles = $this->collaboratorLogic($collaboratorReactProfiles);
        $phpProfiles = $this->collaboratorLogic($collaboratorPhpProfiles);

        $uniqueCollaborators = $this->uniqueCollaborators($reactProfiles, $phpProfiles);

        return $uniqueCollaborators;
    }
}
