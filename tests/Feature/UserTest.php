<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * 
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_can_register_user()
    {
        $userData = [
            'nom' => 'teste',
            'prenom' => 'teste',
            'email' => 'teste@example.com',
            'password' => 'password',
            'datedeNaissance' => '1990-01-01',
            'telephone' => '+123456789',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200);
    }

    public function test_can_login()
    {
        User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'nom' => 'admin',
            'prenom' => 'faye',
            'datedeNaissance' => '1999-01-01',
            'telephone' => '771232425'
        ]);

        $userData = [
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $userData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    public function test_can_get_authenticated_user()
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/me');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "id",
            "nom",
            "prenom",
            "datedeNaissance",
            "telephone",
            "email",
            "email_verified_at",
            "role",
            "created_at",
            "updated_at"
        ]);
    }

    public function test_can_logout()
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out',
        ]);
    }

    public function test_can_refresh_token()
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    protected function getAuthToken()
    {
        User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'nom' => 'admin',
            'prenom' => 'faye',
            'datedeNaissance' => '1999-01-01',
            'telephone' => '771232425'
        ]);

        $userData = [
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ];

        $loginResponse = $this->postJson('/api/login', $userData);

        return $loginResponse->json('access_token');
    }
}
