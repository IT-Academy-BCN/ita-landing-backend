<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FaqsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method.
     * Unauthenticated user has access to this route too.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_index(): void
    {
        Faq::factory()->count(3)->create();
        $faq = Faq::find(3);
        $this->getJson(route('faq.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $faq->id,
                'title' => $faq->title,
                'description' => $faq->description,
            ]);
    }

    /**
     * Test index method with token.
     * Authenticated user has access to this route too.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_index_with_token(): void
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->accessToken;
        Faq::factory()->count(2)->create();
        $faq = Faq::find(2);

        $this->actingAs($user)
            ->withHeaders(['Authorization' => 'Bearer '.$token])
            ->getJson(route('faq.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $faq->id,
                'title' => $faq->title,
                'description' => $faq->description,
            ]);
    }

    /**
     * Test show method
     * Shows a single FAQ with all its available translations.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_show()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $faq = Faq::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get(route('faq.show', $faq->id));

        $response->assertStatus(200)
            ->assertJson([
                'faq' => [
                    'id' => $faq->id,
                    'created_at' => $faq->created_at->toJSON(),
                    'updated_at' => $faq->updated_at->toJSON(),
                    'title' => $faq->title,
                    'description' => $faq->description,
                    'translations' => [
                        [
                            'id' => $faq->translations->first()->id,
                            'faq_id' => $faq->translations->first()->faq_id,
                            'title' => $faq->translations->first()->title,
                            'description' => $faq->translations->first()->description,
                            'locale' => $faq->translations->first()->locale,
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Test show method without token.
     * Get Unauthenticated error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_show_without_token()
    {
        Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get(route('faq.show', $faq->id))
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * Test store method with token.
     * Stores a Faq in a specific language.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_store()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $payload = [
            'title' => 'Títol en català',
            'description' => 'Descripció',
        ];
        $this->actingAs($user)
            ->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson(route('faq.store', ['language' => 'ca']), $payload)
            ->assertStatus(201)
            ->assertValid()
            ->assertJsonFragment([
                'title' => 'Títol en català',
                'description' => 'Descripció',
                'locale' => 'ca',
            ]);
    }

    /**
     * Test store method without token.
     * Try to store a Faq in a specific language and get Unauthenticated error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_store_without_token()
    {
        Artisan::call('passport:install');

        $payload = [
            'title' => 'Test FAQ',
            'description' => 'This is a test FAQ',
        ];

        $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->postJson(route('faq.store', ['language' => 'ca']), $payload)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * Test store method with token missing language parameter.
     * Only authenticated users have access to this route.
     * Get error message.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_store_missing_language_parameter()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $payload = [
            'title' => 'Títol en català',
            'description' => 'Descripció',
        ];
        $this
            ->actingAs($user)
            ->withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])
            ->postJson(route('faq.store'), $payload)
            ->assertStatus(422)
            ->assertJsonFragment([
                'language' => [
                    'El camp language és obligatori.',
                ],
            ]);
    }

    /**
     * Test store method with missing title and/or description.
     * Get different error messages.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_store_with_missing_fields()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;
        // Missing title
        $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson(
                route('faq.store', ['language' => 'ca']),
                [
                    'description' => 'This is a test FAQ',
                ]
            )
            ->assertStatus(422)
            ->assertJsonFragment([
                'title' => [
                    'El camp títol és obligatori.',
                ],
            ])
            ->assertJsonMissing([
                'description' => 'This is a test FAQ',
            ]);
        // Missing description
        $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson(
                route('faq.store', ['language' => 'ca']),
                [
                    'title' => 'Test FAQ title',
                ]
            )
            ->assertStatus(422)
            ->assertJsonFragment([
                'description' => [
                    'El camp descripció és obligatori quan hi ha títol.',
                ],
            ])
            ->assertJsonMissing([
                'title' => 'Títol en català',
            ]);
        // Missing title and description
        $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson(route('faq.store', ['language' => 'ca']), [])
            ->assertStatus(422)
            ->assertJsonFragment([
                'title' => [
                    'El camp títol és obligatori.',
                ],
            ])
            ->assertJsonMissing([
                [
                    'id' => 1,
                ],
            ]);
    }

    /**
     * Test store method with a title longer than allowed.
     * Get 'validation.max.string' error message.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_cannot_store_with_long_title()
    {
        Artisan::call('passport:install');
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $payload = [
            'title' => 'Títol en català escrit moltes vegadas aixì molt cunyat,
             Títol en català escrit moltes vegadas aixì molt cunyat,
             Títol en català escrit moltes vegadas aixì molt cunyat,
             Títol en català escrit moltes vegadas aixì molt cunyat',
            'description' => 'Description',
        ];
        $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson(route('faq.store', ['language' => 'ca']), $payload)
            ->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'title' => [
                        'Títol no pot ser més gran que 255 caràcters.',
                    ],
                ],
            ]);
    }

    /**
     * Test update method.
     * Check if the correct answer is getted.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_update()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;
        // Create a new FAQ in Catalan
        $data = [
            'ca' => [
                'title' => 'Títol en català',
                'description' => 'Descripció en català',
            ],
        ];
        $faq = Faq::factory()->create($data)/*->setDefaultLocale('ca')*/;

        $newData = [
            'title' => 'Title in English.',
            'description' => 'Description in English.',
        ];
        // Update the FAQ
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept-Language' => 'en', // The main FAQ title is set following the Accept_Language header language
        ])->putJson(route('faq.update', ['faq' => $faq->id, 'language' => 'en']), $newData);

        $faq->refresh();

        $response
            ->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'message' => __('api.faq_translation_updated'),
                'faq' => [
                    'id' => $faq->id,
                    'created_at' => $faq->created_at->toJSON(),
                    'updated_at' => $faq->updated_at->toJSON(),
                    'title' => $faq->title,
                    'description' => $faq->description,
                    'translations' => [
                        [
                            'id' => $faq->translations->first()->id,
                            'faq_id' => $faq->id,
                            'title' => $faq->translations->first()->title,
                            'description' => 'Descripció en català',
                            'locale' => 'ca',
                        ],
                        [
                            'locale' => 'en',
                            'title' => $newData['title'], // 'Title in English'
                            'description' => 'Description in English.',
                            'faq_id' => $faq->id,
                            'id' => $faq->translations->where('locale', 'en')->first()->id,
                        ],
                    ],
                ],
            ]);
        $this->assertEquals($newData['title'], $faq->title);
        $this->assertEquals($newData['description'], $faq->description);
        $this->assertDatabaseHas('faq_translations', $newData);
    }

    /**
     * Test update method without token.
     * Get Unauthenticated error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_update_without_token()
    {
        Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->putJson(route('faq.update', ['faq' => $faq->id, 'language' => 'en']), [])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * Test update method with a non-existent FAQ.
     * Get 404 Not-Found error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_update_with_non_existent_id()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;
        Faq::factory()->count(3)->create();
        $this
            ->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->putJson(route('faq.update', ['faq' => Faq::max('id') + 1, 'language' => 'en']), [
                'title' => 'Title in English.',
                'description' => 'Description in English.',
            ])
            ->assertStatus(404)
            ->assertJson([
                'error' => __('api.faq_not_found'),
            ]);
    }

    /**
     * Test update method with a too long title.
     * Get 422 Unprocessable Entity error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_cannot_update_with_long_title()
    {

        Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $data = [
            'title' => 'Títol en català',
            'description' => 'Descripció',
        ];
        $this->postJson(route('faq.store', '?language=ca'), $data);

        $newData = [
            'title' => 'Títol en català escrit moltes vegadas aixì molt cunyat,
             Títol en català escrit moltes vegadas aixì molt cunyat,
             Títol en català escrit moltes vegadas aixì molt cunyat,
             Títol en català escrit moltes vegadas aixì molt cunyat',
            'description' => 'Description',
        ];

        $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->putJson(route('faq.update', ['faq' => $faq->id, 'language' => 'ca']), $newData)
            ->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'title' => [
                        'Títol no pot ser més gran que 255 caràcters.',
                    ],
                ],
            ]);
    }

    /**
     * Test destroy only one translation of a FAQ.
     * Get 200 OK.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_destroy_a_faq_translation()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->accessToken;

        $faq = Faq::factory()->create();

        $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept-Language' => 'en',
        ])->deleteJson(route('faq.destroy', ['faq' => $faq->id, 'language' => 'ca']))
            ->assertStatus(200)
            ->assertOk()
            ->assertJsonFragment([
                'message' => __('api.faq_translation_deleted'), //'message' language depends on the Accept-Language
            ]);
        $this->assertDatabaseMissing('faq_translations', ['locale' => 'ca']);
    }

    /**
     * Test destroy method, deleting the whole FAQ.
     * Get 200 OK.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_destroy_whole_faq()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->accessToken;

        Faq::factory()->count(3)->create();

        $faqId = Faq::first()->id;

        $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept-Language' => 'en',
        ])->deleteJson(route('faq.destroy', ['faq' => $faqId]))
            ->assertStatus(200)
            ->assertJson([
                'message' => __('api.faq_deleted'), // 'message language depends on the Accept-Language header
            ]);
        $this->assertDatabaseMissing('faqs', ['id' => $faqId]);
    }

    /**
     * Test the destroy method without token.
     * Get Unauthenticated error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_destroy_without_token()
    {
        Artisan::call('passport:install');

        $faq = Faq::factory()->create();

        $this->deleteJson(route('faq.destroy', ['faq' => $faq->id]))
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
        $this->assertDatabaseHas('faqs', ['id' => $faq->id]);
    }

    /**
     * Test destroy method with a non-existent FAQ.
     * Get 404 Not-Found error.
     * Only authenticated users have access to this route.
     *
     * @test
     *
     * @group FaqsAndAppsTests
     */
    public function test_destroy_with_non_existent_id()
    {
        Artisan::call('passport:install');

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;
        Faq::factory()->count(2)->create();

        $nonExistentId = Faq::max('id') + 1;

        $this->actingAs($user)->withHeaders(['Authorization' => 'Bearer '.$token])
            ->deleteJson(route('faq.destroy', ['faq' => $nonExistentId]))
            ->assertStatus(404)
            ->assertJson([
                'error' => __('api.faq_not_found'),
            ]);
    }
}
