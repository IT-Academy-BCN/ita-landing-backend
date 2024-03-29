<?php

namespace Tests\Feature;

use App\Mail\MailableCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_ok_Response_when_email_is_sended_with_valid_email()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->post('/api/send-email', ['email' => 'test@yahoo.com']);

        $response->assertStatus(200);

    }

    public function test_email_is_not_sended_with_invalid_email()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->post('/api/send-email', ['email' => 'jfut76']);

        $response->assertStatus(400);
    }

    public function test_email_is_sent_to_the_specified_email()
    {
        Mail::fake();
        $user = User::factory()->create();
        $email = 'test@yahoo.com';

        $this->actingAs($user, 'api')->post('/api/send-email', ['email' => $email]);

        Mail::assertSent(MailableCode::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }
}
