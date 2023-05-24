<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

     /**
     * A user can be logged in successfully with a valid credentials
     *
     */
    public function test_a_user_can_be_logged_in(): void
    {
        \Artisan::call('passport:install');

        User::create([
            'name' => 'Gabriela',
            'email' => 'gaby@gmail.com',
            'dni' => '39986987S',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        $response = $this->postJson(route('login'), [
            'dni' => '39986987S',
            'password' => 'password'
        ]);
        
        $response->assertOk();
        $response->assertJsonStructure([
                'result' => [
                    'message',
                    'access_token',
                ],
                'status'
            ]);

        $this->assertAuthenticated();
    }

    
}
