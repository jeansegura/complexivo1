<?php

namespace Database\Factories;

use App\Models\PublicEntity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PublicEntity>
 */
class PublicEntityFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->company().' Publica';

        return [
            'parent_id' => null,
            'name' => $name,
            'ruc' => fake()->unique()->numerify('#############'),
            'code' => Str::upper(fake()->unique()->bothify('ENT-###')),
            'sector' => fake()->randomElement(['Salud', 'Educacion', 'Gobierno', 'Produccion']),
            'type' => fake()->randomElement(['Ministerio', 'Gobierno Autonomo', 'Empresa Publica', 'Secretaria']),
            'status' => PublicEntity::STATUS_ACTIVE,
            'description' => fake()->sentence(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => PublicEntity::STATUS_INACTIVE,
        ]);
    }
}
