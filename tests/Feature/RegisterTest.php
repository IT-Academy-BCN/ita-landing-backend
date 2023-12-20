<?php

namespace Tests\Feature;

use App\Models\Code;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test basic store user
     */
    public function test_store_with_valid_data(): void
    {

        $userData = User::factory()->makeOne(['dni' => '48042812K']);
        $code = $this->createCode();

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
            'code' => $code['code'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => $userData['name'],
            'dni' => $userData['dni'],
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ])->assertDatabaseHas('codes', [
            'code' => $code['code'],
        ]);

    }

    public function test_can_not_store_with_code_that_exists_but_its_used_already(): void
    {

        $userData = User::factory()->makeOne(['dni' => '48042812K']);
        $code = $this->createCode(true);

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
            'code' => $code['code'],
        ]);

        $response->assertJson(['status' => false]);

    }

    public function test_can_not_store_with_code_that_doesnt_exists(): void
    {

        $userData = User::factory()->makeOne(['dni' => '48042812K']);
        $code = 'kajsbfeklq';

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
            'code' => $code,
        ]);

        $response->assertJson(['status' => false]);

    }

    private function createCode($isUsed = false)
    {
        $code = Code::create([
            'code' => Str::random(10),
            'is_used' => $isUsed,
        ]);

        return $code;
    }

    /**
     * Test store user without name
     */
    public function test_store_with_valid_data_and_without_name(): void
    {
        $userData = User::factory()->makeOne(['dni' => '35983746Q']);
        $code = $this->createCode();

        $response = $this->post('/api/register', [
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
            'code' => $code['code'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ])->assertDatabaseHas('codes', [
            'code' => $code['code'],
        ]);
    }

    /**
     * Test store user with invalid DNI
     */
    public function test_store_with_invalid_dni(): void
    {
        $userData = User::factory()->makeOne(['dni' => '35983747Q']);

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);
    }

    /**
     * Test store user with valid NIE
     */
    public function test_store_with_valid_nie(): void
    {
        $userData = User::factory()->makeOne(['dni' => 'Z6383416R']);
        $code = $this->createCode();

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
            'code' => $code['code'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    /**
     * Test store user with invalid NIE
     */
    public function test_store_with_invalid_nie(): void
    {
        $userData = User::factory()->makeOne(['dni' => 'Z6383416Q']);

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);
    }

    /**
     * Test store user without obligatory fields
     */
    public function test_store_with_obligatory_fields(): void
    {
        $userData = User::factory()->makeOne(['dni' => '36372839H']);

        $response = $this->post('/api/register', [
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);

        $response = $this->post('/api/register', [
            'email' => $userData['email'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);

        $response = $this->post('/api/register', [
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);
    }

    /**
     * Test store user with short password
     */
    public function test_store_with_short_password(): void
    {
        $userData = User::factory()->makeOne(['dni' => '89137481S', 'password' => 'pas']);

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);
    }

    /**
     * Test store user with taken email
     */
    public function test_store_with_taken_email(): void
    {
        $userData = User::create([
            'name' => 'name',
            'email' => 'email@email.com',
            'dni' => '57591829J',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        $response = $this->post('/api/register', [
            'email' => $userData['email'],
            'dni' => '57591829J',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);
    }

    /**
     * Test store user with taken DNI
     */
    public function test_store_with_taken_dni(): void
    {
        $userData = User::create([
            'name' => 'name',
            'email' => 'email@email.com',
            'dni' => '57591829J',
            'password' => bcrypt('password'),
            'status' => 'ACTIVE',
            'role' => 'ADMIN',
        ]);

        $response = $this->post('/api/register', [
            'email' => 'email@email.com',
            'dni' => $userData['dni'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
            ]);
    }
}
