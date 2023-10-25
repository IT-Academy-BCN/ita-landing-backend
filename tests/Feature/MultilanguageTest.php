<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\App;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class MultilanguageTest extends TestCase
{
    use RefreshDatabase;
    

    /** @test */
    public function get_validation_error_in_multiple_languages(): void
    {
        $token = $this->authCreated();

        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson(route('app.store'),);
        $response1->assertStatus(500)->assertSee('El camp url');

        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept-Language' => 'es'])
            ->postJson(route('app.store'),);
        $response2->assertStatus(500)->assertSee('El campo url');

    }

    /** @test */
    public function create_multilanguage_app_as_authenticated_user(): void
    {

        $app = [
            'ca' => ['title' => 'El joc de les cadires',
                     'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => 'El juego de las sillas',
                     'description' => 'Juego con más de un jugador que consiste en...'],
            'url' => 'https://chairgame.com',
            'github' => 'https://github.com',
            'state' => 'COMPLETED'
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])
            ->postJson(route('app.store'), $app);
        $response->assertSee('El juego de las sillas');
        $response->assertStatus(201);
    }

    /** @test */
    public function create_multilanguage_faq_as_authenticated_user(): void
    {

        $faq = [
            'ca' => ['title' => 'De què va el joc de les cadires?',
                     'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => '¿En qué consiste el juego de las sillas?',
                     'description' => 'Juego con más de un jugador que consiste en...'],
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authCreated()])
            ->postJson(route('faq.store'), $faq);
        $response->assertSee('consiste el juego de las sillas');
        $response->assertStatus(201);
    }

    /** @test */
    public function update_multilanguage_app_as_authenticated_user(): void
    {
        $app = [
            'ca' => ['title' => 'El joc de les cadires',
                     'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => 'El juego de las sillas',
                     'description' => 'Juego con más de un jugador que consiste en...'],
            'url' => 'https://chairgame.com',
            'github' => 'https://github.com',
            'state' => 'COMPLETED'
        ];
        
        $token = $this->authCreated();

        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('app.store'), $app);
        
        $target_id = $response1['id'];

        $modifications = ['ca' => ['title' => 'El joc de les taules']];
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson(route('app.update', ['id' => $target_id]), $modifications);

        $response2->assertStatus(200);

    }

    /** @test */
    public function update_multilanguage_faq_as_authenticated_user(): void
    {
        $faq = [
            'ca' => ['title' => 'De què va el joc de les cadires?',
                     'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => '¿En qué consiste el juego de las sillas?',
                     'description' => 'Juego con más de un jugador que consiste en...'],
        ];
        
        $token = $this->authCreated();

        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('faq.store'), $faq);
        
        $modifications = ['es' => ['title' => '¿En qué consiste el juego de las mesas?']];
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson(route('faq.update', ['id' => 1]), $modifications);

        $response2->assertStatus(200);

    }

    /** @test */
    public function get_app_in_multiple_languages_as_authenticated_user(): void
    {
        $app = [
            'ca' => ['title' => 'El joc de les cadires',
                     'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => 'El juego de las sillas',
                     'description' => 'Juego con más de un jugador que consiste en...'],
            'url' => 'https://chairgame.com',
            'github' => 'https://github.com',
            'state' => 'COMPLETED'
        ];

        $token = $this->authCreated();
        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('app.store'), $app);

        
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept-Language' => 'ca'])
            ->getJson(route('app.show', ['id' => 1]));
        $response2->assertStatus(200)->assertSee('joc');


        $response3 = $this->withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept-Language' => 'es'])
            ->getJson(route('app.show', ['id' => 1]));
        $response3->assertStatus(200)->assertSee('juego');

    }
    
    /** @test */
    public function get_faq_in_multiple_languages_as_authenticated_user(): void
    {
        $faq = [
            'ca' => ['title' => 'De què va el joc de les cadires?',
                     'description' => 'Joc amb més d\'un jugador que consisteix en...'],
            'es' => ['title' => '¿En qué consiste el juego de las sillas?',
                     'description' => 'Juego con más de un jugador que consiste en...'],
        ];

        $token = $this->authCreated();
        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('faq.store'), $faq);

        
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept-Language' => 'ca'])
            ->getJson(route('faq.show', ['id' => 1]));
        $response2->assertStatus(200)->assertSee('joc');


        $response3 = $this->withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept-Language' => 'es'])
            ->getJson(route('faq.show', ['id' => 1]));
        $response3->assertStatus(200)->assertSee('juego');

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
        return $token = $user->createToken('auth_token')->accessToken;
        
    }

}
