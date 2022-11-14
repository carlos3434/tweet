<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(){
        $user = User::factory()->create();
        $token = $user->createToken('AppName')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    public function testUsersAreCreatedCorrectly()
    {
        $headers = $this->authenticate();
        $payload = [
            'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ];

        $this->json('POST', '/api/users', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['first_name' => 'test', 'last_name' => 'test', 'username' => 'test', 'email' => 'test@gmail.com']);
    }

    public function testRequireFirstNameWhenUserIsCreated()
    {
        $headers = $this->authenticate();
        $payload = [
            //'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ];
        $this->json('POST', '/api/users', $payload, $headers)
            ->assertStatus(422)
            ->assertJson(
                [
                    "message" =>  "The given data was invalid.",
                    "errors" =>  [
                        "first_name" =>  ["The first name field is required."],
                    ]
                ]
            );
    }

    public function testRequireLastNameWhenUserIsCreated()
    {
        $headers = $this->authenticate();
        $payload = [
            'first_name' => 'test',
            //'last_name' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',];
        $this->json('POST', '/api/users', $payload, $headers)
            ->assertStatus(422)
            ->assertJson(
                [
                    "message" =>  "The given data was invalid.",
                    "errors" =>  [
                        "last_name" =>  ["The last name field is required."],
                    ]
                ]
            );
    }

    public function testUsersAreCreatedOk()
    {
        $headers = $this->authenticate();
        $payload = [
            'first_name' => 'test2',
            'last_name' => 'test2',
            'username' => 'test2',
            'email' => 'test2@gmail.com',
            'password' => 'password',
        ];

        $this->json('POST', '/api/users', $payload, $headers);

        $this->assertCount(2, User::all());
        foreach ( User::all() as $user) {}

        $this->assertEquals($user->first_name, 'test2');
        $this->assertEquals($user->last_name, 'test2');
        $this->assertEquals($user->username, 'test2');
        $this->assertEquals($user->email, 'test2@gmail.com');
    }

    public function testUsersAreUpdatedCorrectly()
    {
        $headers = $this->authenticate();
        $user = User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $payload = [
            'first_name' => 'test 1',
            'last_name' => 'test 1',
            'username' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => 'password',
        ];

        $response = $this->json('PUT', '/api/users/' . $user->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                //'id' => 1,
                'first_name' => 'test 1',
                'last_name' => 'test 1',
                'username' => 'test1',
                'email' => 'test1@gmail.com',
                //'password' => 'password',
            ]);
    }

    public function testUsersAreDeletedCorrectly()
    {
        $headers = $this->authenticate();
        $user = User::factory()->create([
            'first_name' => 'test 1',
            'last_name' => 'test 1',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $this->json('DELETE', '/api/users/' . $user->id, [], $headers)
            ->assertStatus(204);
    }

    public function testFindUserCorrectly()
    {
        $headers = $this->authenticate();
        $user = User::factory()->create([
            'first_name' => 'test 1',
            'last_name' => 'test 1',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $this->json('GET', '/api/users/'.$user->id, [], $headers)
            ->assertStatus(200)
            ->assertJson(
                [
                    'first_name' => 'test 1',
                    'last_name' => 'test 1',
                    'username' => 'test',
                    'email' => 'test@gmail.com',
                ]
            );
    }

    public function testCouldNotFindUser()
    {
        //$this->withoutExceptionHandling();
        $headers = $this->authenticate();
        User::factory()->create([
            'first_name' => 'test 1',
            'last_name' => 'test 1',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $this->json('GET', '/api/users/21', [], $headers)
            ->assertStatus(404)
            ->assertJson(
                [ "message"=> "Record not found." ]
            );
    }

    public function testUsersAreListedCorrectly()
    {
        User::factory()->create([
            'first_name' => 'second test',
            'last_name' => 'secondtest',
            'username' => 'test2',
            'email' => 'test2@gmail.com',
            'password' => 'password',
        ]);
        User::factory()->create([
            'first_name' => 'first test',
            'last_name' => 'first test',
            'username' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => 'password',
        ]);

        $headers = $this->authenticate();

        $this->json('GET', '/api/users', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [
                    'first_name' => 'second test',
                    'last_name' => 'secondtest',
                    'username' => 'test2',
                    'email' => 'test2@gmail.com',
                ],
                [
                    'first_name' => 'first test',
                    'last_name' => 'first test',
                    'username' => 'test1',
                    'email' => 'test1@gmail.com',
                ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'first_name', 'last_name', 'username', 'created_at', 'updated_at'],
            ]);
    }

}
