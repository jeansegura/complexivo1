<?php

namespace Tests\Feature;

use App\Models\PublicEntity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicEntityManagementTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_planner_cannot_access_entity_management(): void
    {
        $planner = User::factory()->planner()->create();

        $this->actingAs($planner)
            ->get(route('entities.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_entities_index(): void
    {
        $this->actingAsAdmin();
        PublicEntity::factory()->create(['name' => 'Ministerio de Educacion']);

        $this->get(route('entities.index'))
            ->assertOk()
            ->assertSee('Entidades publicas')
            ->assertSee('Ministerio de Educacion');
    }

    public function test_admin_can_create_entity(): void
    {
        $this->actingAsAdmin();

        $this->post(route('entities.store'), [
            'name' => 'Gobierno Provincial de Loja',
            'ruc' => '1160000000001',
            'code' => 'GPL',
            'sector' => 'Gobierno',
            'type' => 'Gobierno Autonomo',
            'status' => PublicEntity::STATUS_ACTIVE,
            'description' => 'Entidad provincial.',
        ])->assertRedirect(route('entities.index'));

        $this->assertDatabaseHas('public_entities', [
            'name' => 'Gobierno Provincial de Loja',
            'ruc' => '1160000000001',
            'status' => PublicEntity::STATUS_ACTIVE,
        ]);
    }

    public function test_admin_can_filter_entities_by_sector(): void
    {
        $this->actingAsAdmin();
        PublicEntity::factory()->create(['name' => 'Entidad Salud', 'sector' => 'Salud']);
        PublicEntity::factory()->create(['name' => 'Entidad Educacion', 'sector' => 'Educacion']);

        $this->get(route('entities.index', ['sector' => 'Salud']))
            ->assertOk()
            ->assertSee('Entidad Salud')
            ->assertDontSee('Entidad Educacion');
    }

    public function test_admin_can_update_entity(): void
    {
        $this->actingAsAdmin();
        $entity = PublicEntity::factory()->create();

        $this->put(route('entities.update', $entity), [
            'name' => 'Entidad Actualizada',
            'ruc' => $entity->ruc,
            'code' => 'ENT-ACT',
            'sector' => 'Produccion',
            'type' => 'Empresa Publica',
            'status' => PublicEntity::STATUS_INACTIVE,
            'description' => 'Datos actualizados.',
        ])->assertRedirect(route('entities.index'));

        $this->assertDatabaseHas('public_entities', [
            'id' => $entity->id,
            'name' => 'Entidad Actualizada',
            'status' => PublicEntity::STATUS_INACTIVE,
        ]);
    }

    public function test_admin_deactivates_entity_instead_of_deleting_it(): void
    {
        $this->actingAsAdmin();
        $entity = PublicEntity::factory()->create();

        $this->delete(route('entities.destroy', $entity))
            ->assertRedirect(route('entities.index'));

        $this->assertDatabaseHas('public_entities', [
            'id' => $entity->id,
            'status' => PublicEntity::STATUS_INACTIVE,
        ]);
    }
}
