<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_user_can_ask_for_the_email_to_reset_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('forget.password'), [
            'email' => $user->email,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'message',
        ]);
    }

    public function test_user_cant_ask_for_the_email_cause_the_email_dont_exist(): void
    {

        $response = $this->post(route('forget.password'), [
            'email' => 'prueba@prueba.com',
        ]);

        $response->assertStatus(204);
    }

    public function test_updating_token_for_an_existing_email_on_reset_password_table(): void
    {
        $user = User::factory()->create();
        $email = $user->email;
        $token = Str::random(10);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
        ]);

        $response = $this->post(route('forget.password'), [
            'email' => $email,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'message',
        ]);
    }

    public function test_user_can_reset_password(): void
    {
        $user = User::factory()->create();
        $email = $user->email;
        $token = Str::random(10);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
        ]);

        $response = $this->post(route('reset.password', $token), [
            'password' => 'newpassword',
            'password_confirm' => 'newpassword',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'message',
        ]);
    }

    public function test_user_cant_reset_password_cause_put_it_wrong(): void
    {
        $user = User::factory()->create();
        $email = $user->email;
        $token = Str::random(10);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
        ]);

        $response = $this->post(route('reset.password', $token), [
            'token' => $token,
            'password' => 'newpassword',
            'password_confirm' => 'newpawwrodd',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_have_wrong_token(): void
    {
        $user = User::factory()->create();
        $email = $user->email;
        $token = Str::random(10);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => '1234567',
        ]);

        $response = $this->post(route('reset.password', $token), [
            'token' => $token,
            'password' => 'newpassword',
            'password_confirm' => 'newpassword',
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'error',
        ]);
    }
}
