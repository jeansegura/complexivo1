<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PublicEntity;
use App\Models\Role;
use App\Models\StrategicObjective;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = collect([
            ['module' => 'usuarios', 'action' => 'ver', 'slug' => 'usuarios.ver'],
            ['module' => 'usuarios', 'action' => 'crear', 'slug' => 'usuarios.crear'],
            ['module' => 'usuarios', 'action' => 'editar', 'slug' => 'usuarios.editar'],
            ['module' => 'usuarios', 'action' => 'desactivar', 'slug' => 'usuarios.desactivar'],
            ['module' => 'roles', 'action' => 'ver', 'slug' => 'roles.ver'],
            ['module' => 'roles', 'action' => 'crear', 'slug' => 'roles.crear'],
            ['module' => 'roles', 'action' => 'editar', 'slug' => 'roles.editar'],
            ['module' => 'roles', 'action' => 'desactivar', 'slug' => 'roles.desactivar'],
            ['module' => 'entidades', 'action' => 'ver', 'slug' => 'entidades.ver'],
            ['module' => 'entidades', 'action' => 'crear', 'slug' => 'entidades.crear'],
            ['module' => 'entidades', 'action' => 'editar', 'slug' => 'entidades.editar'],
            ['module' => 'entidades', 'action' => 'desactivar', 'slug' => 'entidades.desactivar'],
            ['module' => 'objetivos', 'action' => 'ver', 'slug' => 'objetivos.ver'],
            ['module' => 'objetivos', 'action' => 'crear', 'slug' => 'objetivos.crear'],
            ['module' => 'objetivos', 'action' => 'editar', 'slug' => 'objetivos.editar'],
            ['module' => 'objetivos', 'action' => 'desactivar', 'slug' => 'objetivos.desactivar'],
        ])->map(fn (array $permission) => Permission::firstOrCreate(
            ['slug' => $permission['slug']],
            [
                'module' => $permission['module'],
                'action' => $permission['action'],
                'description' => 'Permiso para '.$permission['action'].' en '.$permission['module'].'.',
            ],
        ));

        $adminRole = Role::firstOrCreate(
            ['slug' => 'administrador'],
            [
                'name' => 'Administrador',
                'description' => 'Rol con acceso administrativo al sistema.',
                'level' => 9,
                'is_active' => true,
            ],
        );

        $plannerRole = Role::firstOrCreate(
            ['slug' => 'planificador'],
            [
                'name' => 'Planificador',
                'description' => 'Rol para registrar y consultar informacion de planificacion.',
                'level' => 3,
                'is_active' => true,
            ],
        );

        $adminRole->permissions()->sync($permissions->pluck('id')->all());
        $plannerRole->permissions()->sync($permissions->whereIn('module', ['entidades', 'objetivos'])->pluck('id')->all());

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
            ],
        );

        $entity = PublicEntity::firstOrCreate(
            ['ruc' => '1760000000001'],
            [
                'name' => 'Secretaria Nacional de Planificacion',
                'code' => 'SNP',
                'sector' => 'Gobierno',
                'type' => 'Secretaria',
                'status' => PublicEntity::STATUS_ACTIVE,
                'description' => 'Entidad rectora de la planificacion nacional.',
            ],
        );

        StrategicObjective::firstOrCreate(
            [
                'public_entity_id' => $entity->id,
                'code' => 'OE-001',
            ],
            [
                'name' => 'Fortalecer la gestion de la planificacion institucional',
                'description' => 'Objetivo base para articular planificacion, seguimiento y evaluacion institucional.',
                'pnd_alignment' => 'Plan Nacional de Desarrollo',
                'ods_alignment' => 'ODS 16',
                'start_year' => 2026,
                'end_year' => 2029,
                'status' => StrategicObjective::STATUS_ACTIVE,
            ],
        );
    }
}
