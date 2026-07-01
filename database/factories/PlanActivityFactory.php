<?php

namespace Database\Factories;

use App\Models\InstitutionalPlan;
use App\Models\PlanActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanActivity>
 */
class PlanActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'institutional_plan_id' => InstitutionalPlan::factory(),
            'name' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'responsible_unit' => fake()->randomElement(['Planificacion', 'Administrativo', 'Tecnologia', 'Seguimiento']),
            'budget' => fake()->randomFloat(2, 1000, 50000),
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'status' => PlanActivity::STATUS_PENDING,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => PlanActivity::STATUS_COMPLETED,
        ]);
    }
}
