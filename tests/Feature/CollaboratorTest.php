<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\api\CollaboratorsController;
use Illuminate\Foundation\Testing\TestResponse;

class CollaboratorTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_get_all_collaborators(): void
    {
        $response = $this->get('/api/collaborators');

        $response->assertStatus(200);
    }
    
    public function test_inserting_on_index_a_area_that_dont_exist(): void
    {
        $response = $this->get('/api/collaborators/prueba');

        $response->assertStatus(404);
    }

    public function test_collaborator_php_function(){

        $collaboratorsController = new CollaboratorsController();

        $response= $collaboratorsController->collaboratorPhp();

        $this->assertIsArray($response);
    }

    public function test_collaborator_react_function(){

        $collaboratorsController = new CollaboratorsController();

        $response= $collaboratorsController->collaboratorFrontedReact();

        $this->assertIsArray($response);
    }

    public function test_collaborator_angular_function(){

        $collaboratorsController = new CollaboratorsController();

        $response= $collaboratorsController->collaboratorFrontedAngular();

        $this->assertIsArray($response);
    }

    public function test_collaborator_java_function(){

        $collaboratorsController = new CollaboratorsController();

        $response= $collaboratorsController->collaboratorJava();

        $this->assertIsArray($response);
    }

    public function test_collaborator_node_function(){

        $collaboratorsController = new CollaboratorsController();

        $response= $collaboratorsController->collaboratorNode();

        $this->assertIsArray($response);
    }
}
