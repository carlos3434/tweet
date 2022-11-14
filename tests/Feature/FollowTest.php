<?php

namespace Tests\Feature;

use App\Models\Follow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function authenticate(){
        $this->user = User::factory()->create();
        $token = $this->user->createToken('AppName')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    //con sus seguidores
    public function testUsersWithTheirFollowers() {
        $user1 = User::factory()->create([
            'first_name' => 'second test',
            'last_name' => 'secondtest',
            'username' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => 'password',
        ]);
        $user2 = User::factory()->create([
            'first_name' => 'first test',
            'last_name' => 'first test',
            'username' => 'test2',
            'email' => 'test2@gmail.com',
            'password' => 'password',
        ]);
        $user3 = User::factory()->create([
            'first_name' => 'third test',
            'last_name' => 'third test',
            'username' => 'test3',
            'email' => 'test3@gmail.com',
            'password' => 'password',
        ]);

        $headers = $this->authenticate();

        $this->json('POST', '/api/followTosomeone', ['follower_id' => $user1->id], $headers)
            ->assertStatus(201);
        $this->json('POST', '/api/followTosomeone', ['follower_id' => $user2->id], $headers)
            ->assertStatus(201);
        $this->json('POST', '/api/followTosomeone', ['follower_id' => $user3->id], $headers)
            ->assertStatus(201);

        $this->assertCount(3, Follow::all());

        $this->json('GET', '/api/followersCount', $headers)
            ->assertStatus(200)
            ->assertJson([
                'followersCount' => 3,
            ]);

    }
    //con sus seguidos
    public function testUsersWithTheirFollowings() {
        $user1 = User::factory()->create([
            'first_name' => 'second test',
            'last_name' => 'secondtest',
            'username' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => 'password',
        ]);
        $user2 = User::factory()->create([
            'first_name' => 'first test',
            'last_name' => 'first test',
            'username' => 'test2',
            'email' => 'test2@gmail.com',
            'password' => 'password',
        ]);
        $user3 = User::factory()->create([
            'first_name' => 'third test',
            'last_name' => 'third test',
            'username' => 'test3',
            'email' => 'test3@gmail.com',
            'password' => 'password',
        ]);

        $headers = $this->authenticate();

        $this->json('POST', '/api/followTosomeone', ['follower_id' => $user1->id], $headers)
            ->assertStatus(201);

        Follow::create([
            'followed_id' => $user1->id,
            'follower_id' => $this->user->id
        ]);
        Follow::create([
            'followed_id' => $user2->id,
            'follower_id' => $this->user->id
        ]);
        Follow::create([
            'followed_id' => $user3->id,
            'follower_id' => $this->user->id
        ]);

        $this->assertCount(3, Follow::where('follower_id',$this->user->id)->get());

        $this->json('GET', '/api/followingsCount', $headers)
            ->assertStatus(200)
            ->assertJson([
                'followingsCount' => 3,
            ]);
    }
}
