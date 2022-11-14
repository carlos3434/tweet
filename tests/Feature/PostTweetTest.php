<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PostTweetTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function authenticate(){
        $this->user = User::factory()->create();
        $token = $this->user->createToken('AppName')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    public function testTweetIsCreatedCorrectly()
    {
        $headers = $this->authenticate();
        $payload = [
            'message' => 'test',
        ];

        $this->json('POST', '/api/tweets', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['message' => 'test', 'user_id' => $this->user->id]);
    }

}
