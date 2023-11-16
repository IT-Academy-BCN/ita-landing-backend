<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
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

        $user = UserFactory::new()->create();

        $response = $this->postJson(route('login'), [
            'dni' => $user->dni,
            'password' => 'password', // Default password from the factory
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

        UserFactory::new()->create(['dni' => 'Y5177867Y', 'password' => 'password']);

        $response = $this->postJson(route('login'), [
            'dni' => 'Z6126330D',
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

        $user = UserFactory::new()->create(['password' => bcrypt('password')]);

        $response = $this->postJson(route('login'), [
            'dni' => $user->dni,
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

        UserFactory::new()->create(['dni' => 'Y5177867Y']);


        $response = $this->postJson(route('login'), [
            'dni' => '39986987N',
            'password' => 'password', // Default password from the factory
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

        $user = UserFactory::new()->create();
        // Check if field is originally NULL
        $original_last_login_at = $user->last_login_at;
        $this->assertNull($original_last_login_at);

        $response = $this->postJson(route('login'), [
            'dni' => $user->dni,
            'password' => 'password', // Default password from the factory
        ]);

        $response->assertOk();
        $user->refresh();
        $first_last_login_at = $user->last_login_at;
        $this->assertNotNull($first_last_login_at);

        // Wait 1 second to ensure that field datetime is different
        sleep(1);
        // login again
        $response = $this->postJson(route('login'), [
            'dni' => $user->dni,
            'password' => 'password', // Default password from the factory
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

        $user = UserFactory::new()->create(['password' => bcrypt('password')]);

        // Check if field is originally NULL
        $this->assertNull($user->last_login_at);

        $response = $this->postJson(route('login'), [
            'dni' => $user->dni,
            'password' => 'wrongPassword',
        ]);
        // Check failed login
        $response->assertStatus(401);
        $user->refresh();
        $this->assertNull($user->last_login_at);
    }
}
