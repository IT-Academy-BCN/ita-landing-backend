<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test basic store user
     */
    public function testStoreWithValidData(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '35983746Q']);

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
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
        ]);
    }

    /**
     * Test store user without name
     */
    public function testStoreWithValidDataAndWithoutName(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '35983746Q']);

        $response = $this->post('/api/register', [
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
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
        ]);
    }

    /**
     * Test store user with invalid DNI
     */
    public function testStoreWithInvalidDni(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '35983747Q']);

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
    public function testStoreWithValidNie(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => 'Z6383416R']);

        $response = $this->post('/api/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'dni' => $userData['dni'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    /**
     * Test store user with invalid NIE
     */
    public function testStoreWithInvalidNie(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => 'Z6383416Q']);

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
    public function testStoreWithoutObligatoryFields(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '36372839H']);

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
    public function testStoreWithShortPassword(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '89137481S', 'password' => 'pas']);

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
    public function testStoreWithTakenEmail(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '97491829G']);
        \App\Models\User::create(array_merge($userData->toArray(), ['password' => $userData['password']]));

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
    public function testStoreWithTakenDNI(): void
    {
        $userData = \App\Models\User::factory()->makeOne(['dni' => '57591829J']);
        \App\Models\User::create(array_merge($userData->toArray(), ['password' => $userData['password']]));

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
