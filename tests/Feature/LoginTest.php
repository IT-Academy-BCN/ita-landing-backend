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
            'dni' => '39986946S',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        $response = $this->postJson(route('login'), [
            'dni' => '39986946S',
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

    /**
     * A user can not be logged in successfully with a invalid credentials
     *
     */
    public function test_a_user_can_not_be_logged_in_with_both_fields_wrong(): void
    {
        \Artisan::call('passport:install');

        User::create([
            'name' => 'Gabriela',
            'email' => 'gaby@gmail.com',
            'dni' => '39986946S',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        $response = $this->postJson(route('login'), [
            'dni' => '39986987N',
            'password' => 'wrongPassword'
        ]);
        
        $response->assertStatus(401);
        $response->assertJson([
                'result' => [
                    'message' => 'Invalid credentials'
                ],
                'status' => false
            ]);

        $this->assertGuest();
    }
    
    /**
     * A user can not be logged in successfully with missing fields
     *
     */
    public function test_a_user_cannot_be_logged_in_with_missing_fields(): void
    {
        $response = $this->postJson(route('login'), []);
        
        $response->assertStatus(422);
        
    }

    /**
     * A user can not be logged in successfully with an incorrect password
     */
    public function test_a_user_cannot_be_logged_in_with_wrong_password(): void
    {
        \Artisan::call('passport:install');

        User::create([
            'name' => 'Gabriela',
            'email' => 'gaby@gmail.com',
            'dni' => '39986946S',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        $response = $this->postJson(route('login'), [
            'dni' => '39986946S',
            'password' => 'wrongPassword'
        ]);
        
        $response->assertStatus(401);
        $response->assertJson([
            'result' => [
                'message' => 'Invalid credentials'
            ],
            'status' => false
        ]);

        $this->assertGuest();
    }

}
