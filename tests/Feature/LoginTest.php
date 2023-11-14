<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can be logged in successfully with a valid credentials
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
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'result' => [
                'message',
                'access_token',
            ],
            'status',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * A user can not be logged in successfully with a invalid credentials
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
            'password' => 'wrongPassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'result' => [
                'message' => 'Invalid credentials',
            ],
            'status' => false,
        ]);

        $this->assertGuest();
    }

    /**
     * A user can not be logged in successfully with missing fields
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
            'password' => 'wrongPassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'result' => [
                'message' => 'Invalid credentials',
            ],
            'status' => false,
        ]);

        $this->assertGuest();
    }

    /**
     * A user cannot be logged in successfully with an incorrect DNI
     */
    public function test_a_user_cannot_be_logged_in_with_wrong_dni(): void
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
            'password' => 'password',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'result' => [
                'message' => 'Invalid credentials',
            ],
            'status' => false,
        ]);

        $this->assertGuest();
    }

    /**
     *  User last login time is saved and updated
     */
    public function test_a_user_last_login_is_saved_and_updated(): void
    {
        \Artisan::call('passport:install');

        $user = User::create([
            'name' => 'Francisco',
            'email' => 'fran@mail.com',
            'dni' => 'Z2314216F',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);
        // Check if field is originally NULL
        $original_last_login_at = $user->last_login_at;
        $this->assertNull($original_last_login_at);

        $response = $this->postJson(route('login'), [
            'dni' => 'Z2314216F',
            'password' => 'password',
        ]);

        $response->assertOk();
        $user->refresh();
        $first_last_login_at = $user->last_login_at;
        $this->assertNotNull($first_last_login_at);

        // Wait 1 second to ensure that field datetime is different
        sleep(1);
        // login again
        $response = $this->postJson(route('login'), [
            'dni' => 'Z2314216F',
            'password' => 'password',
        ]);

        $response->assertOk();
        $user->refresh();
        // Check if field was updated
        $second_last_login_at = $user->last_login_at;
        $this->assertNotEquals($first_last_login_at, $second_last_login_at);
    }

    /**
     *  User last login time is not saved on failed login
     */
    public function test_last_login_at_is_not_updated_on_failed_login(): void
    {
        \Artisan::call('passport:install');

        $user = User::create([
            'name' => 'Francisco',
            'email' => 'fran@mail.com',
            'dni' => 'Z2314216F',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);
        $this->assertNull($user->last_login_at);

        $response = $this->postJson(route('login'), [
            'dni' => 'Z2314216F',
            'password' => 'wrongPassword',
        ]);
        // Check failed login
        $response->assertStatus(401);
        $user->refresh();
        $this->assertNull($user->last_login_at);
    }
}
