<?php

namespace Tests\Feature;

use App\Models\InstitutionalPlan;
use App\Models\PlanActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanActivityManagementTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_admin_can_view_plan_with_activities(): void
    {
        $this->actingAsAdmin();
        $plan = InstitutionalPlan::factory()->create(['code' => 'PEI-ACT']);
        PlanActivity::factory()->create([
            'institutional_plan_id' => $plan->id,
            'name' => 'Actividad de seguimiento',
        ]);

        $this->get(route('plans.show', $plan))
            ->assertOk()
            ->assertSee('PEI-ACT')
            ->assertSee('Actividad de seguimiento');
    }

    public function test_admin_can_create_plan_activity(): void
    {
        $this->actingAsAdmin();
        $plan = InstitutionalPlan::factory()->create();

        $this->post(route('plans.activities.store', $plan), [
            'name' => 'Registrar avance trimestral',
            'description' => 'Registro de avance del periodo.',
            'responsible_unit' => 'Seguimiento',
            'budget' => 2500,
            'start_date' => '2026-01-01',
            'end_date' => '2026-03-31',
            'status' => PlanActivity::STATUS_IN_PROGRESS,
        ])->assertRedirect(route('plans.show', $plan));

        $this->assertDatabaseHas('plan_activities', [
            'institutional_plan_id' => $plan->id,
            'name' => 'Registrar avance trimestral',
            'status' => PlanActivity::STATUS_IN_PROGRESS,
        ]);
    }

    public function test_admin_can_update_plan_activity(): void
    {
        $this->actingAsAdmin();
        $activity = PlanActivity::factory()->create();
        $plan = $activity->institutionalPlan;

        $this->put(route('plans.activities.update', [$plan, $activity]), [
            'name' => 'Actividad actualizada',
            'description' => 'Detalle actualizado.',
            'responsible_unit' => 'Tecnologia',
            'budget' => 3500,
            'start_date' => '2026-02-01',
            'end_date' => '2026-05-30',
            'status' => PlanActivity::STATUS_COMPLETED,
        ])->assertRedirect(route('plans.show', $plan));

        $this->assertDatabaseHas('plan_activities', [
            'id' => $activity->id,
            'name' => 'Actividad actualizada',
            'status' => PlanActivity::STATUS_COMPLETED,
        ]);
    }

    public function test_admin_deactivates_plan_activity_instead_of_deleting_it(): void
    {
        $this->actingAsAdmin();
        $activity = PlanActivity::factory()->create();
        $plan = $activity->institutionalPlan;

        $this->delete(route('plans.activities.destroy', [$plan, $activity]))
            ->assertRedirect(route('plans.show', $plan));

        $this->assertDatabaseHas('plan_activities', [
            'id' => $activity->id,
            'status' => PlanActivity::STATUS_INACTIVE,
        ]);
    }

    public function test_activity_must_belong_to_plan(): void
    {
        $this->actingAsAdmin();
        $plan = InstitutionalPlan::factory()->create();
        $activity = PlanActivity::factory()->create();

        $this->get(route('plans.activities.edit', [$plan, $activity]))
            ->assertNotFound();
    }
}
