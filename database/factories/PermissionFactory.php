<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    public function definition(): array
    {
        $module = fake()->randomElement(['usuarios', 'roles', 'planes', 'reportes']);
        $action = fake()->unique()->word();

        return [
            'module' => $module,
            'action' => $action,
            'slug' => Str::slug($module.' '.$action),
            'description' => fake()->sentence(),
        ];
    }
}
