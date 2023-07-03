<?php

namespace Tests\Feature\Api;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class EvaluationTest extends TestCase
{
    /**
     * Get empty evaluation.
     */
    public function test_get_evaluations_empty(): void
    {
        $response = $this->getJson('/evaluations/fake-company');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    /**
     * Get all Evaluations.
     */
    public function test_get_evaluations(): void
    {
        $countEvaluations = 6;
        $company = (string) Str::uuid();

        Evaluation::factory()->count($countEvaluations)->create([
            'company' => $company,
        ]);

        $response = $this->getJson("/evaluations/{$company}");

        $response->assertStatus(200)
            ->assertJsonCount($countEvaluations, 'data');
    }

    /**
     * Store validation Evaluation.
     */
    public function test_error_store_evaluation(): void
    {
        $company = 'fake-company';

        $response = $this->postJson("/evaluations/{$company}", []);

        $response->assertStatus(422);
    }

    /**
     * Store Evaluation.
     */
    public function test_error_evaluation(): void
    {
        $response = $this->postJson('/evaluations/fake-company', [
            'company'   => (string) Str::uuid(),
            'comment'   => 'New Commnet',
            'stars'     => 5,
        ]);

        $response->assertStatus(404);
    }
}
