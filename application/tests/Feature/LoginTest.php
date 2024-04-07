<?php

namespace Tests\Feature\Auth;

use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        $this->initDatabase();
    }

    public function initDatabase(): void {
        // Configura banco na memoria
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        config(['database.connections.mysql.foreign_key_constraints' => false]);

        // Roda migrations
        Artisan::call('migrate');
        // Roda seeds
        Artisan::call('db:seed');

    }

    /**
     * A basic login example.
     */
    public function test_login_success(): void
    {
        $user = User::create([
            'name' => 'Victor Nunes',
            'email' => 'victor@mailinator.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
            ],
            'message',
            'metadata'
        ]);

        $this->assertAuthenticated();
    }

    /**
     * test for password invalid.
     */
    public function test_login_password_invalid(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * test for email invalid.
     */
    public function test_login_email_invalid(): void
    {
        $credentials = [
            'email' => 'test123@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/auth/login', $credentials);

        $response->assertStatus(401);
    }
}
