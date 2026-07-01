<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalPlan;
use App\Models\PlanActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanActivityController extends Controller
{
    public function create(InstitutionalPlan $plan)
    {
        $statuses = $this->statuses();

        return view('plan-activities.create', compact('plan', 'statuses'));
    }

    public function store(Request $request, InstitutionalPlan $plan)
    {
        $validated = $request->validate($this->rules());

        $plan->activities()->create($validated);

        return redirect()->route('plans.show', $plan)->with('success', 'Actividad agregada correctamente.');
    }

    public function edit(InstitutionalPlan $plan, PlanActivity $activity)
    {
        $this->ensureActivityBelongsToPlan($plan, $activity);

        $statuses = $this->statuses();

        return view('plan-activities.edit', compact('plan', 'activity', 'statuses'));
    }

    public function update(Request $request, InstitutionalPlan $plan, PlanActivity $activity)
    {
        $this->ensureActivityBelongsToPlan($plan, $activity);

        $validated = $request->validate($this->rules());

        $activity->update($validated);

        return redirect()->route('plans.show', $plan)->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(InstitutionalPlan $plan, PlanActivity $activity)
    {
        $this->ensureActivityBelongsToPlan($plan, $activity);

        $activity->update(['status' => PlanActivity::STATUS_INACTIVE]);

        return redirect()->route('plans.show', $plan)->with('success', 'Actividad desactivada correctamente.');
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:220',
            'description' => 'nullable|string|max:1200',
            'responsible_unit' => 'required|string|max:160',
            'budget' => 'required|numeric|min:0|max:999999999.99',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => ['required', Rule::in(array_keys($this->statuses()))],
        ];
    }

    private function statuses(): array
    {
        return [
            PlanActivity::STATUS_PENDING => 'Pendiente',
            PlanActivity::STATUS_IN_PROGRESS => 'En ejecucion',
            PlanActivity::STATUS_COMPLETED => 'Completada',
            PlanActivity::STATUS_INACTIVE => 'Inactiva',
        ];
    }

    private function ensureActivityBelongsToPlan(InstitutionalPlan $plan, PlanActivity $activity): void
    {
        abort_unless($activity->institutional_plan_id === $plan->id, 404);
    }
}
