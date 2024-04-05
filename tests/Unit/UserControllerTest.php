<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
    }

    public function testLoginFailure()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertUnauthorized();
        $response->assertJson([
            'message' => 'Log in failed',
        ]);
    }

    public function testRegisterSuccess()
    {
        $userData = User::factory()->make()->toArray();

        $response = $this->postJson('/api/register', array_merge(
            $userData,
            ['password' => 'password', 'password_confirmation' => 'password']
        ));

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'updated_at',
                'created_at',
            ],
            'access_token',
            'token_type',
        ]);
    }

    public function testRegisterFailure()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }
}