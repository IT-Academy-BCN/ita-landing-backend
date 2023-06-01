<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\App;

class AppTest extends TestCase
{
    use RefreshDatabase;
    
    
    public function test_can_get_all_apps(): void
    {
        App::factory(3)->create();

        $response = $this->getJson(route('app.index'));

        $response->assertStatus(200);
        $response->json();
    }

    public function test_can_store_an_app_with_valid_data(): void
    {
        $app = [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'url' => fake()->url(),
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON'])
        ];
        
        $this->postJson(route('app.store'), $app);
    
        $this->assertDatabaseHas('apps', $app); 
    }

    public function test_can_not_store_an_app_with_a_missing_field(): void
    {
        $app = [
            'title' => '',
            'description' => fake()->text(),
            'url' => fake()->url(),
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON'])
        ];
        
        $response = $this->postJson(route('app.store'), $app);
    
        $response->assertStatus(422);
    }

    public function test_can_not_store_an_app_with_wrong_data(): void
    {
        $app = [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'url' => 123355, // must be text
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON'])
        ];
        
        $response = $this->postJson(route('app.store'), $app);

        $response->assertJsonValidationErrorFor('url');
    
    }

    public function test_can_not_store_an_app_with_empty_fields(): void
    {
        $app = [
            'title' => '',
            'description' => '',
            'url' => '',
            'state' => [],
        ];
        
        $response = $this->postJson(route('app.store'), $app);
    
        $response->assertStatus(422);
    }

    public function test_can_show_an_app(): void
    {
        $app = App::factory()->create();

        $response = $this->getJson(route('app.show', $app));

        $response->assertJson([
            'title' => $app->title,
            'description' => $app->description,
            'url' => $app->url,
            'state' => $app->state,
        ]);
    }

    public function test_can_not_show_an_app_that_it_doesnt_exists(): void
    {
        App::factory()->create();

        $response = $this->getJson(route('app.show', ['id' => '2']));

        $response->assertStatus(404);
    }

    public function test_can_update_an_app_with_valid_data(): void
    {
        $app = App::factory()->create();

        $newData = [
            'title' => 'Title updated',
            'description' => $app->description,
            'url' => $app->url,
            'state' => $app->state,
        ];
        
        $this->postJson(route('app.store'), $newData);
    
        $this->assertDatabaseHas('apps', $newData); 
    }

    public function test_can_not_update_an_app_with_missing_field(): void
    {
        $app = App::factory()->create();

        $newData = [
            'title' => '',
            'description' => $app->description,
            'url' => $app->url,
            'state' => $app->state,
        ];
        
        $response = $this->postJson(route('app.store'), $newData);
    
        $response->assertStatus(422); 
    }

    public function test_can_delete_an_app(): void
    {
        $app = App::factory()->create();

        $this->deleteJson(route('app.destroy', $app));
        
        $this->assertDatabaseCount('apps', 0);
    }

    public function test_can_not_delete_an_app_that_it_doesnt_exists(): void
    {
        App::factory()->create();

        $response = $this->deleteJson(route('app.destroy', ['id' => '2']));

        $response->assertStatus(404);
    }

}
