<?php

namespace Database\Factories;

use App\Models\InstitutionalPlan;
use App\Models\PublicEntity;
use App\Models\StrategicObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InstitutionalPlan>
 */
class InstitutionalPlanFactory extends Factory
{
    public function definition(): array
    {
        $entity = PublicEntity::factory();

        return [
            'public_entity_id' => $entity,
            'strategic_objective_id' => StrategicObjective::factory()->for($entity, 'publicEntity'),
            'code' => fake()->unique()->bothify('PLAN-###'),
            'name' => fake()->sentence(5),
            'type' => fake()->randomElement(['PEI', 'POA', 'Plan operativo']),
            'description' => fake()->paragraph(),
            'start_year' => 2026,
            'end_year' => 2029,
            'status' => InstitutionalPlan::STATUS_DRAFT,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => [
            'status' => InstitutionalPlan::STATUS_APPROVED,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => InstitutionalPlan::STATUS_INACTIVE,
        ]);
    }
}
