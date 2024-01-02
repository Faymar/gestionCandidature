<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Formation;
use Illuminate\Http\UploadedFile;

class FormationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_list_of_formations()
    {

        $response = $this->getJson('/api/listFormations');

        $response->assertStatus(200);
    }

    public function test_can_create_formation()
    {
        $data = [
            'nomFormation' => 'Test Formation',
            'dateDebut' => '2023-01-01',
            'dateFin' => '2023-02-01',
            'fichier' => UploadedFile::fake()->create('document.pdf'),
        ];

        $response = $this->postJson('/api/ajouterFormation', $data);

        $response->assertStatus(200);
    }

    public function test_can_get_single_formation()
    {
        $formation = Formation::factory()->create();

        $response = $this->getJson('/api/voirFormation/' . $formation->id);

        $response->assertStatus(200);
        $response->assertJson($formation->toArray());
    }

    public function test_can_update_formation()
    {
        $formation = Formation::factory()->create();

        $updatedData = [
            'nomFormation' => 'Updated Formation',
            'dateDebut' => '2023-02-01',
            'dateFin' => '2023-03-01',
        ];

        $response = $this->patchJson('/api/modifierFormation/' . $formation->id, $updatedData);

        $response->assertStatus(200);
    }

    public function test_can_delete_formation()
    {
        $formation = Formation::factory()->create();

        $response = $this->deleteJson("/api/supprimerFormation/{$formation->id}");

        $response->assertStatus(200);
    }
}
