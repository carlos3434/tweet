<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson(
                [
                    "message" =>  "The given data was invalid.",
                    "errors" =>  [
                        "email" =>  ["The email field is required."],
                        "password" => ["The password field is required."]
                    ]
                ]
            );
    }


    public function testUserLoginsSuccessfully()
    {
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'last',
            'username' => 'username',
            'email'=> $email = time().'@example.com',
            'password' => bcrypt('toptal123')
        ]);

        $payload = ['email' => $email, 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
                'token_type',
                'expires_at',
            ]);
    }
}
