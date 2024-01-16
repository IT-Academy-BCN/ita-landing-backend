<?php

namespace Tests\Feature;

use App\Http\Controllers\api\CollaboratorsController;
use Tests\TestCase;

class CollaboratorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_index_get_collaborators_landing(): void
    {
        $response = $this->get('/api/collaborators/landing');
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_index_get_collaborators_ita_wiki(): void
    {
        $response = $this->get('/api/collaborators/wiki');
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_index_get_collaborators_challenges(): void
    {
        $response = $this->get('/api/collaborators/challenges');
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_inserting_on_index_a_area_that_dont_exist(): void
    {
        $response = $this->get('/api/collaborators/prueba');
        $response->assertStatus(404);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_collaborators_logic(): void
    {

        $php = '/ita-landing-backend/collaborators?affiliation=direct';
        $collaboratorsController = new CollaboratorsController();
        $response = $collaboratorsController->collaboratorLogic($php);

        $this->assertIsArray($response);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_collaborator_landing_function()
    {

        $collaboratorsController = new CollaboratorsController();
        $response = $collaboratorsController->collaboratorLanding();
        $this->assertIsArray($response);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_collaborator_ita_wiki_function()
    {

        $collaboratorsController = new CollaboratorsController();
        $response = $collaboratorsController->collaboratorItaWiki();
        $this->assertIsArray($response);
    }

    /**
     * @test
     *
     * @group CollaboratorTest
     */
    public function test_collaborator_challenges_function()
    {

        $collaboratorsController = new CollaboratorsController();
        $response = $collaboratorsController->collaboratorItaChallenges();
        $this->assertIsArray($response);
    }
}
