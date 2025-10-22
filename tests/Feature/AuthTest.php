<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PasswordResetToken;  
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function complete_auth_flow_works()
    {
        // 1. Register a user
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        
        $response->assertStatus(200);
        $emailToken = $response->json('data.email_token');

        // 2. Verify email with token from registration
        $this->postJson('/api/v1/auth/verify-email', [
            'token' => $emailToken,
        ])->assertStatus(200);

        // 3. Login
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        
        $loginResponse->assertStatus(200);
        $authToken = $loginResponse->json('data.token');

        // 4. Logout with token from login
        $this->withHeader('Authorization', 'Bearer ' . $authToken)
            ->postJson('/api/v1/auth/logout')
            ->assertStatus(200);
    }

    /** @test */
    public function forgot_password_creates_reset_token()
    {
        // Create a verified user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        // Request password reset
        $response = $this->postJson('/api/v1/auth/forgot-password', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200);

        // Verify token was created in database
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function password_reset_flow_works()
    {
        // Create a verified user with password that includes SALT
        $salt = env('SALT', '');
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('oldpassword123' . $salt),
        ]);

        // 1. Generate a plain token and store it hashed (simulating forgot password flow)
        $plainToken = Str::random(60);
        PasswordResetToken::create([
            'email' => 'test@example.com',
            'token' => Hash::make($plainToken),
        ]);

        // 2. Reset password with the plain token
        $this->postJson('/api/v1/auth/reset-password', [
            'old_password' => 'oldpassword123',
            'new_password' => 'newpassword123',
            'token' => $plainToken,
        ])->assertStatus(200);

        // 3. Verify can login with new password
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'newpassword123',
        ]);
        
        $loginResponse->assertStatus(200);
    }

    /** @test */
    public function validation_works()
    {
        // Verify endpoints reject invalid data
        $this->postJson('/api/v1/auth/register')->assertStatus(422);
        $this->postJson('/api/v1/auth/login')->assertStatus(422);
        $this->postJson('/api/v1/auth/verify-email')->assertStatus(422);
        $this->postJson('/api/v1/auth/forgot-password')->assertStatus(422);
        $this->postJson('/api/v1/auth/reset-password')->assertStatus(422);
    }

    /** @test */
    public function health_check_works()
    {
        $this->get('/up')->assertStatus(200);
    }
}