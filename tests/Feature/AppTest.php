<?php

namespace Tests\Feature;

use App\Models\App;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AppTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_apps_unauthenticated_user(): void
    {
        App::factory(3)->create();

        $response = $this->getJson(route('app.index'));

        $response->assertStatus(200);
        $response->json();
    }

    public function test_can_get_all_apps_authenticated_user(): void
    {
        App::factory(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->getJson(route('app.index'));

        $response->assertStatus(200);
        $response->json();
    }

    public function test_can_store_an_app_with_valid_data(): void
    {
        $app = [
            'ca' => [
                'title' => fake()->title(),
                'description' => fake()->text(),
            ],
            'es' => [
                'title' => fake()->title(),
                'description' => fake()->text(),
            ],
            'url' => fake()->url(),
            'github' => 'https://github.com',
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON']),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->postJson(route('app.store'), $app);
        $response->assertStatus(201);
    }

    public function test_can_not_store_an_app_without_token(): void
    {
        $app = [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'url' => fake()->url(),
            'github' => 'https://github.com',
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON']),
        ];

        $response = $this->postJson(route('app.store'), $app);

        $response->assertStatus(401);
    }

    public function test_can_not_store_an_app_with_a_missing_field(): void
    {
        $app = [
            'description' => fake()->text(),
            'url' => fake()->url(),
            'github' => 'https://github.com',
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON']),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->postJson(route('app.store'), $app);

        $response->assertStatus(422);
    }

    public function test_can_not_store_an_app_with_wrong_data(): void
    {
        $app = [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'url' => 12345,
            'github' => 'https://github.com',
            'state' => fake()->randomElement(['COMPLETED', 'IN PROGRESS', 'SOON']),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->postJson(route('app.store'), $app);

        $response->assertStatus(422);
        $response->assertJsonFragment(['error' => 'Url no és una adreça web vàlida.']);

    }

    public function test_can_not_store_an_app_with_empty_fields(): void
    {
        $app = [
            'title' => '',
            'description' => '',
            'url' => '',
            'github' => '',
            'state' => [],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->postJson(route('app.store'), $app);

        $response->assertStatus(422);
    }

    public function test_can_show_an_app(): void
    {
        $app = App::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->getJson(route('app.show', $app));

        $response->assertJson([
            'title' => $app->title,
            'description' => $app->description,
            'url' => $app->url,
            'github' => $app->github,
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

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->getJson(route('app.show', ['id' => '2']));

        $response->assertStatus(404);
    }

    public function test_can_update_an_app_with_valid_data(): void
    {
        $app = [
            'ca' => ['title' => 'El joc de les cadires',
                'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => 'El juego de las sillas',
                'description' => 'Juego con más de un jugador que consiste en...'],
            'url' => 'https://chairgame.com',
            'github' => 'https://github.com',
            'state' => 'COMPLETED',
        ];

        $token = $this->authCreated();

        $response1 = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('app.store'), $app);

        $target_id = $response1['id'];
        $modifications = [
            'ca' => ['title' => 'El joc de les taules'],
            'es' => ['title' => 'El juego de las sillas'],
        ];

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson(route('app.update', ['id' => $target_id]), $modifications);

        $response2->assertStatus(200);
    }

    public function test_can_not_update_an_app_without_token(): void
    {
        $app = App::factory()->create();

        $newData = [
            'title' => 'Title updated',
            'description' => $app->description,
            'url' => $app->url,
            'github' => $app->github,
            'state' => $app->state,
        ];

        $response = $this->putJson(route('app.update', $app->id), $newData);

        $response->assertStatus(401);
    }

    public function test_can_not_update_an_app_with_missing_field(): void
    {
        $app = App::factory()->create();

        $newData = [
            'description' => $app->description,
            'url' => $app->url,
            'github' => $app->github,
            'state' => $app->state,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->putJson(route('app.update', $app->id), $newData);

        $response->assertStatus(422);
    }

    public function test_can_delete_an_app(): void
    {
        $app = App::factory()->create();

        $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->deleteJson(route('app.destroy', $app));

        $this->assertDatabaseCount('apps', 0);
    }

    public function test_can_not_delete_an_app_that_it_doesnt_exists(): void
    {
        App::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->authCreated(),
        ])->deleteJson(route('app.destroy', ['id' => '2']));

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
        Artisan::call('passport:install');

        $user = User::create([
            'name' => 'Gabriela',
            'email' => 'gaby@gmail.com',
            'dni' => '39986946S',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        return $user->createToken('auth_token')->accessToken;

    }
}
