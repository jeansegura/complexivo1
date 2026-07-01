<?php

namespace Database\Factories;

use App\Models\PublicEntity;
use App\Models\StrategicObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StrategicObjective>
 */
class StrategicObjectiveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'public_entity_id' => PublicEntity::factory(),
            'code' => fake()->unique()->bothify('OE-###'),
            'name' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'pnd_alignment' => 'Eje '.fake()->numberBetween(1, 5),
            'ods_alignment' => 'ODS '.fake()->numberBetween(1, 17),
            'start_year' => 2026,
            'end_year' => 2029,
            'status' => StrategicObjective::STATUS_DRAFT,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => StrategicObjective::STATUS_ACTIVE,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => StrategicObjective::STATUS_INACTIVE,
        ]);
    }
}
