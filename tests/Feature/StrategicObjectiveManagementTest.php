<?php

namespace Tests\Feature;

use App\Models\PublicEntity;
use App\Models\StrategicObjective;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StrategicObjectiveManagementTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_planner_cannot_access_objective_management(): void
    {
        $planner = User::factory()->planner()->create();

        $this->actingAs($planner)
            ->get(route('objectives.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_objectives_index(): void
    {
        $this->actingAsAdmin();
        StrategicObjective::factory()->create(['code' => 'OE-PLAN']);

        $this->get(route('objectives.index'))
            ->assertOk()
            ->assertSee('Objetivos estrategicos')
            ->assertSee('OE-PLAN');
    }

    public function test_admin_can_create_objective(): void
    {
        $this->actingAsAdmin();
        $entity = PublicEntity::factory()->create();

        $this->post(route('objectives.store'), [
            'public_entity_id' => $entity->id,
            'code' => 'OE-001',
            'name' => 'Incrementar la calidad del servicio publico',
            'description' => 'Objetivo institucional de prueba.',
            'pnd_alignment' => 'Eje social',
            'ods_alignment' => 'ODS 16',
            'start_year' => 2026,
            'end_year' => 2029,
            'status' => StrategicObjective::STATUS_ACTIVE,
        ])->assertRedirect(route('objectives.index'));

        $this->assertDatabaseHas('strategic_objectives', [
            'public_entity_id' => $entity->id,
            'code' => 'OE-001',
            'status' => StrategicObjective::STATUS_ACTIVE,
        ]);
    }

    public function test_admin_can_filter_objectives_by_entity(): void
    {
        $this->actingAsAdmin();
        $entity = PublicEntity::factory()->create(['name' => 'Entidad Uno']);
        $otherEntity = PublicEntity::factory()->create(['name' => 'Entidad Dos']);
        StrategicObjective::factory()->create(['public_entity_id' => $entity->id, 'code' => 'OE-UNO']);
        StrategicObjective::factory()->create(['public_entity_id' => $otherEntity->id, 'code' => 'OE-DOS']);

        $this->get(route('objectives.index', ['public_entity_id' => $entity->id]))
            ->assertOk()
            ->assertSee('OE-UNO')
            ->assertDontSee('OE-DOS');
    }

    public function test_admin_can_update_objective(): void
    {
        $this->actingAsAdmin();
        $objective = StrategicObjective::factory()->create();

        $this->put(route('objectives.update', $objective), [
            'public_entity_id' => $objective->public_entity_id,
            'code' => 'OE-EDIT',
            'name' => 'Objetivo actualizado',
            'description' => 'Descripcion actualizada.',
            'pnd_alignment' => 'Eje economico',
            'ods_alignment' => 'ODS 8',
            'start_year' => 2026,
            'end_year' => 2030,
            'status' => StrategicObjective::STATUS_INACTIVE,
        ])->assertRedirect(route('objectives.index'));

        $this->assertDatabaseHas('strategic_objectives', [
            'id' => $objective->id,
            'code' => 'OE-EDIT',
            'status' => StrategicObjective::STATUS_INACTIVE,
        ]);
    }

    public function test_admin_deactivates_objective_instead_of_deleting_it(): void
    {
        $this->actingAsAdmin();
        $objective = StrategicObjective::factory()->active()->create();

        $this->delete(route('objectives.destroy', $objective))
            ->assertRedirect(route('objectives.index'));

        $this->assertDatabaseHas('strategic_objectives', [
            'id' => $objective->id,
            'status' => StrategicObjective::STATUS_INACTIVE,
        ]);
    }
}
