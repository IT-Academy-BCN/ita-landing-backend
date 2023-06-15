<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */

     use RefreshDatabase;

    public function test_can_ask_for_the_email_to_reset_password(): void
    {
        $user= User::factory()->create();
        
        $response = $this->post(route('forgetpassword'),[
            'email'=> $user->email
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'message'
        ]);
    }

    public function test_cant_ask_for_the_email_to_reset_password(): void
    {
        $user= User::factory()->create();
        
        $response = $this->post(route('forgetpassword'),[
            'email'=> 'prueba@prueba.com'
        ]);

        $response->assertStatus(404)->assertJsonStructure([
            'error'
        ]);
    }
}
