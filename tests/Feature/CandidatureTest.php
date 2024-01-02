<?php

namespace Tests\Feature;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CandidatureTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_can_make_demande()
    {
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => 'candidat',
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

        $token = $loginResponse->json('access_token');

        $formation = Formation::factory()->create();


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->actingAs($user)->postJson('/api/faireDemande/' . $formation->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'votre demande est enregistree avec succes']);
    }

    public function test_can_list_demande()
    {
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => 'candidat',
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

        $token = $loginResponse->json('access_token');


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->actingAs($user)->getJson('/api/candidat/listeDemande');

        $response->assertStatus(200);
    }

    public function test_can_list_candidatures()
    {
        $admin = User::factory()->create([
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

        $token = $loginResponse->json('access_token');

        $formation = Formation::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->actingAs($admin)->getJson("/api/listeCandudature/{$formation->id}");

        $response->assertStatus(200);
    }

    public function test_can_accept_demande()
    {
        $admin = User::factory()->create();
        $formation = Formation::factory()->create();
        $candidat = User::factory()->create();

        $loginResponse = $this->postJson('/api/login', [$candidat->email, $candidat->password]);

        $token1 = $loginResponse->json('access_token');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token1,
        ])->actingAs($candidat)->postJson('/api/faireDemande/' . $formation->id);


        $loginResponse = $this->postJson('/api/login', [$admin->email, $admin->password]);
        $token2 = $loginResponse->json('access_token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token2,
        ])->actingAs($admin)->patchJson("/api/accepterDemande/{$candidat->id}/{$formation->id}");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'la demande est acceptee avec sucess']);
    }

    public function test_can_refuse_demande()
    {
        $admin = User::factory()->create();
        $formation = Formation::factory()->create();
        $candidat = User::factory()->create();

        $loginResponse = $this->postJson('/api/login', [$candidat->email, $candidat->password]);

        $token1 = $loginResponse->json('access_token');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token1,
        ])->actingAs($candidat)->postJson('/api/faireDemande/' . $formation->id);


        $loginResponse = $this->postJson('/api/login', [$admin->email, $admin->password]);
        $token2 = $loginResponse->json('access_token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token2,
        ])->actingAs($admin)->patchJson("/api/reufuseDemande/{$candidat->id}/{$formation->id}");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'la demande est refusee avec sucess']);
    }
}
