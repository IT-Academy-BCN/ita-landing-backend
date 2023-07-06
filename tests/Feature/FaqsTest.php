<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Faq;

class FaqsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method. Unauthenticated user have access to this route too.
     */
    public function test_index(): void
    {   
        $faqs = [
            [
                'title' => fake()->sentence,
                'description' => fake()->paragraph,
            ],
            [
                'title' => fake()->sentence,
                'description' => fake()->paragraph,
            ],
        ];
        
        Faq::insert($faqs);

        $response = $this->get('/api/faqs');

        $response->assertStatus(200)
            ->assertJson([
                'faqs' => $faqs
            ]);
    }

    /**
     * Test index method with token. Authenticated user have access to this route too.
     */
    public function test_index_with_token(): void
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->accessToken;

        $faqs = [
            [
                'title' => fake()->sentence,
                'description' => fake()->paragraph,
            ],
            [
                'title' => fake()->sentence,
                'description' => fake()->paragraph,
            ],
        ];
        
        Faq::insert($faqs);

        $response = $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer ' . $token,])->get('/api/faqs');

        $response->assertStatus(200)->assertJson(['faqs' => $faqs]);
    }

    /**
     * Test show method.
     */
    public function test_show()
    {        
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $faq = Faq::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/faqs/' . $faq->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $faq->id,
                'title' => $faq->title,
                'description' => $faq->description
            ]);
    }

    /**
     * Test show method without token.
     */
    public function test_show_without_token()
    {        
        \Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $response = $this->get('/api/faqs/' . $faq->id);

        $response->assertStatus(302);
    }

    /**
     * Test store method.
     */
    public function test_store()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $data = [
            'title' => 'Test FAQ',
            'description' => 'This is a test FAQ'
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/faqs', $data);

        $response->assertStatus(201)
            ->assertJson([
                'faq' => $data
            ]);

        $this->assertDatabaseHas('faqs', $data);
    }

    /**
     * Test store method without token.
     */
    public function test_store_without_token()
    {
        \Artisan::call('passport:install');

        $data = [
            'title' => 'Test FAQ',
            'description' => 'This is a test FAQ'
        ];

        $response = $this->post('/api/faqs', $data);

        $response->assertStatus(302);
    }

    /**
     * Test store method with missing title and/or description.
     */
    public function test_store_with_missing_fields()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        // Missing title
        $data1 = [
            'description' => 'This is a test FAQ'
        ];

        $response1 = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/faqs', $data1);

        $response1->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        // Missing description
        $data2 = [
            'title' => 'Test FAQ'
        ];

        $response2 = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/faqs', $data2);

        $response2->assertStatus(422)
            ->assertJsonValidationErrors(['description']);

        // Missing title and description
        $data3 = [];

        $response3 = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/faqs', $data3);

        $response3->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description']);
    }

    /**
     * Test store method with a too long title.
     */
    public function test_store_with_long_title()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $data = [
            'title' => fake()->paragraph . fake()->paragraph . fake()->paragraph,
            'description' => 'This is a test FAQ'
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/faqs', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    /**
     * Test update method.
     */
    public function test_update()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $faq = Faq::factory()->create();

        $data = [
            'title' => 'Updated FAQ',
            'description' => 'This is an updated FAQ'
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/faqs/' . $faq->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'FAQ updated successfully'
            ]);

        $this->assertDatabaseHas('faqs', $data);
    }

     /**
     * Test update method without token.
     */
    public function test_update_without_token()
    {
        \Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $data = [
            'title' => 'Updated FAQ',
            'description' => 'This is an updated FAQ'
        ];

        $response = $this->put('/api/faqs/' . $faq->id, $data);

        $response->assertStatus(302);
    }

    /**
     * Test update method with a non-existent FAQ.
     */
    public function test_update_with_non_existent_id()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $data = [
            'title' => 'Updated FAQ',
            'description' => 'This is an updated FAQ'
        ];

        $nonExistentId = 9999;

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/faqs/' . $nonExistentId, $data);

        $response->assertStatus(404);
    }

    /**
     * Test update method with a too long title.
     */
    public function test_update_with_long_title()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $faq = Faq::factory()->create();

        $data = [
            'title' => fake()->paragraph . fake()->paragraph . fake()->paragraph,
            'description' => 'This is an updated FAQ'
        ];

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/faqs/' . $faq->id, $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    /**
     * Test destroy method.
     */
    public function test_destroy()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $faqs = Faq::factory(3)->create();
        $faq = $faqs->first();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/faqs/' . $faq->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'FAQ deleted successfully'
            ]);

        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    /**
     * Test the destroy method without token.
     */
    public function test_destroy_without_token()
    {
        \Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $response = $this->delete('/api/faqs/' . $faq->id);

        $response->assertStatus(302);

        $this->assertDatabaseHas('faqs', ['id' => $faq->id]);
    }

    /**
     * Test destroy method with a non-existent FAQ.
     */
    public function test_destroy_with_non_existent_id()
    {
        \Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $nonExistentId = 9999;

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/faqs/' . $nonExistentId);

        $response->assertStatus(404);
    }
}