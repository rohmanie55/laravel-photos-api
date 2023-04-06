<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $user = User::factory()->make();

        $response = $this->postJson(route('auth.register'),array_merge($user->toArray(),['password'=>'12345678']));

        $response->assertStatus(200)
                ->assertJsonStructure(['access_token','token_type','expires_at']);

        $this->assertDatabaseHas('users', ['email'=>$user->email]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'),[
            'email'=>$user->email,
            'password'=>'password'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['access_token','token_type','expires_at']);
    }

    public function test_can_get_user(){
        $response = $this->actingAs($this->user)->getJson(route('auth.user'));

        $response->assertStatus(200)
                ->assertJson($this->user->toArray());
    }

    public function test_user_can_logout(){
        $response = $this->actingAs($this->user)->postJson(route('auth.logout'));

        $response->assertStatus(204);
    }
}
