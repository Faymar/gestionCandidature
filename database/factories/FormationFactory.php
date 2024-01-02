<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formation>
 */
class FormationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomFormation' => fake()->name(),
            'dateDebut' => fake()->date(),
            'dateFin' => fake()->date(),
            'fichier' => UploadedFile::fake()->create('document.pdf'),
        ];
    }
}
