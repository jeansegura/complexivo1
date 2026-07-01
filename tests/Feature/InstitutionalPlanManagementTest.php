<?php

namespace Tests\Feature;

use App\Models\InstitutionalPlan;
use App\Models\PublicEntity;
use App\Models\StrategicObjective;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitutionalPlanManagementTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_planner_cannot_access_plan_management(): void
    {
        $planner = User::factory()->planner()->create();

        $this->actingAs($planner)
            ->get(route('plans.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_plans_index(): void
    {
        $this->actingAsAdmin();
        InstitutionalPlan::factory()->create(['code' => 'PEI-TEST']);

        $this->get(route('plans.index'))
            ->assertOk()
            ->assertSee('Planes institucionales')
            ->assertSee('PEI-TEST');
    }

    public function test_admin_can_create_plan(): void
    {
        $this->actingAsAdmin();
        $entity = PublicEntity::factory()->create();
        $objective = StrategicObjective::factory()->active()->create([
            'public_entity_id' => $entity->id,
            'code' => 'OE-PLAN',
        ]);

        $this->post(route('plans.store'), [
            'public_entity_id' => $entity->id,
            'strategic_objective_id' => $objective->id,
            'code' => 'PEI-2026',
            'name' => 'Plan Estrategico Institucional',
            'type' => 'PEI',
            'description' => 'Plan de prueba.',
            'start_year' => 2026,
            'end_year' => 2029,
            'status' => InstitutionalPlan::STATUS_REVIEW,
        ])->assertRedirect(route('plans.index'));

        $this->assertDatabaseHas('institutional_plans', [
            'public_entity_id' => $entity->id,
            'strategic_objective_id' => $objective->id,
            'code' => 'PEI-2026',
            'status' => InstitutionalPlan::STATUS_REVIEW,
        ]);
    }

    public function test_admin_can_filter_plans_by_entity(): void
    {
        $this->actingAsAdmin();
        $entity = PublicEntity::factory()->create();
        $otherEntity = PublicEntity::factory()->create();
        InstitutionalPlan::factory()->create(['public_entity_id' => $entity->id, 'code' => 'PLAN-UNO']);
        InstitutionalPlan::factory()->create(['public_entity_id' => $otherEntity->id, 'code' => 'PLAN-DOS']);

        $this->get(route('plans.index', ['public_entity_id' => $entity->id]))
            ->assertOk()
            ->assertSee('PLAN-UNO')
            ->assertDontSee('PLAN-DOS');
    }

    public function test_admin_can_update_plan(): void
    {
        $this->actingAsAdmin();
        $plan = InstitutionalPlan::factory()->create();

        $this->put(route('plans.update', $plan), [
            'public_entity_id' => $plan->public_entity_id,
            'strategic_objective_id' => $plan->strategic_objective_id,
            'code' => 'POA-EDIT',
            'name' => 'Plan actualizado',
            'type' => 'POA',
            'description' => 'Plan editado.',
            'start_year' => 2026,
            'end_year' => 2027,
            'status' => InstitutionalPlan::STATUS_APPROVED,
        ])->assertRedirect(route('plans.index'));

        $this->assertDatabaseHas('institutional_plans', [
            'id' => $plan->id,
            'code' => 'POA-EDIT',
            'status' => InstitutionalPlan::STATUS_APPROVED,
        ]);
    }

    public function test_admin_deactivates_plan_instead_of_deleting_it(): void
    {
        $this->actingAsAdmin();
        $plan = InstitutionalPlan::factory()->approved()->create();

        $this->delete(route('plans.destroy', $plan))
            ->assertRedirect(route('plans.index'));

        $this->assertDatabaseHas('institutional_plans', [
            'id' => $plan->id,
            'status' => InstitutionalPlan::STATUS_INACTIVE,
        ]);
    }
}
