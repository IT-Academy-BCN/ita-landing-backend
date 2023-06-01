<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\App;
use App\Models\User;

class AppTest extends TestCase
{
    use RefreshDatabase;
    
    
    public function test_can_get_all_apps(): void
    {
        App::factory(3)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->getJson(route('app.index'));
       
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
        
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->postJson(route('app.store'), $app);
    
        $this->assertDatabaseHas('apps', $app); 
    }

    public function test_can_not_store_an_app_without_token(): void
    {
        $app = [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'url' => fake()->url(),
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON'])
        ];
        
        $response = $this->postJson(route('app.store'), $app);
    
        $response->assertStatus(401);
    }

    public function test_can_not_store_an_app_with_a_missing_field(): void
    {
        $app = [
            'title' => '',
            'description' => fake()->text(),
            'url' => fake()->url(),
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON'])
        ];
        
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->postJson(route('app.store'), $app);
    
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
        
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->postJson(route('app.store'), $app);

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
        
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->postJson(route('app.store'), $app);
    
        $response->assertStatus(422);
    }

    public function test_can_show_an_app(): void
    {
        $app = App::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->getJson(route('app.show', $app));

        $response->assertJson([
            'title' => $app->title,
            'description' => $app->description,
            'url' => $app->url,
            'state' => $app->state,
        ]);
    }

    public function test_can_not_show_an_app_without_token(): void
    {
        $app = App::factory()->create();

        $response = $this->getJson(route('app.show', $app));

        $response->assertStatus(401);
    }

    public function test_can_not_show_an_app_that_it_doesnt_exists(): void
    {
        App::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->getJson(route('app.show', ['id' => '2']));

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
        
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->postJson(route('app.store'), $newData);
    
        $this->assertDatabaseHas('apps', $newData); 
    }

    public function test_can_not_update_an_app_without_token(): void
    {
        $app = App::factory()->create();

        $newData = [
            'title' => 'Title updated',
            'description' => $app->description,
            'url' => $app->url,
            'state' => $app->state,
        ];
            
        $response = $this->postJson(route('app.store'), $newData);

        $response->assertStatus(401); 
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
        
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->postJson(route('app.store'), $newData);
    
        $response->assertStatus(422); 
    }

    public function test_can_delete_an_app(): void
    {
        $app = App::factory()->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->deleteJson(route('app.destroy', $app));
        
        $this->assertDatabaseCount('apps', 0);
    }

    public function test_can_not_delete_an_app_that_it_doesnt_exists(): void
    {
        App::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])->deleteJson(route('app.destroy', ['id' => '2']));

        $response->assertStatus(404);
    }

    public function test_can_not_delete_an_app_without_token(): void
    {
        $app = App::factory()->create();

        $response = $this->deleteJson(route('app.destroy', $app));

        $response->assertStatus(401);
    }

    private function authCreated()
    {
        \Artisan::call('passport:install');

        $user = User::create([
            'name' => 'Gabriela',
            'email' => 'gaby@gmail.com',
            'dni' => '39986946S',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);
        return $token = $user->createToken('auth_token')->accessToken;
        
    }

}
