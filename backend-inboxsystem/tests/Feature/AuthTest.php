<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRightUser(): void
    {
        $user = User::factory()->create([
            'name' => 'Manuel',
            'email' => 'manuel@test.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/sign-in', [
            'email' => 'manuel@test.com',
            'password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);

        $token = $response->json('access_token');

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/user')
            ->assertOk()
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
    public function test_user_cannot_sign_in_with_invalid_credentials(): void
    {
        User::factory()->create([
            'name' => 'Usernsio',
            'email' => 'user@test.com',
            'password' => Hash::make('rigth-password'),
        ]);

        $response = $this->postJson('/api/sign-in', [
            'email' => 'user@test.com',
            'password' => 'wrong-password',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}