<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function testRegistersSuccessfully()
    {
        $payload = [
            'first_name' => 'Test User',
            'last_name' => 'last',
            'username' => 'username',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
            'password_confirmation' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
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

    public function testRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson(
                [
                    "message" =>  "The given data was invalid.",
                    "errors" =>  [
                        'first_name' => ['The first name field is required.'],
                        'last_name' => ['The last name field is required.'],
                        'username' => ['The username field is required.'],
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                    ]
                ]
            );
    }

    public function testRequirePasswordConfirmation()
    {
        $payload = [
            'first_name' => 'Test User',
            'last_name' => 'last',
            'username' => 'username',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    "message" =>  "The given data was invalid.",
                    "errors" =>  [
                        'password' => ['The password confirmation does not match.'],
                    ]
                ]
            );
    }
}
