<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email'=>'adminTest@example.com',
            'password'=>bcrypt('password'),
        ]);
    }

    public function actingAs($user, $driver = null)
    {
        Passport::actingAs($user);
        
        return $this;
    }
}
