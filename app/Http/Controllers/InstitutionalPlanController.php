<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalPlan;
use App\Models\PublicEntity;
use App\Models\StrategicObjective;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstitutionalPlanController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'public_entity_id', 'status']);

        $plans = InstitutionalPlan::query()
            ->with(['publicEntity', 'strategicObjective'])
            ->withCount('activities')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->when($filters['public_entity_id'] ?? null, fn ($query, string $entityId) => $query->where('public_entity_id', $entityId))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->get();

        $entities = PublicEntity::query()->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('plans.index', compact('plans', 'entities', 'filters', 'statuses'));
    }

    public function create()
    {
        $entities = PublicEntity::query()->where('status', PublicEntity::STATUS_ACTIVE)->orderBy('name')->get();
        $objectives = StrategicObjective::query()->where('status', StrategicObjective::STATUS_ACTIVE)->orderBy('code')->get();
        $statuses = $this->statuses();

        return view('plans.create', compact('entities', 'objectives', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        InstitutionalPlan::create($validated);

        return redirect()->route('plans.index')->with('success', 'Plan institucional creado correctamente.');
    }

    public function show(InstitutionalPlan $plan)
    {
        $plan->load(['publicEntity', 'strategicObjective', 'activities']);

        return view('plans.show', compact('plan'));
    }

    public function edit(InstitutionalPlan $plan)
    {
        $entities = PublicEntity::query()->where('status', PublicEntity::STATUS_ACTIVE)->orderBy('name')->get();
        $objectives = StrategicObjective::query()->where('status', StrategicObjective::STATUS_ACTIVE)->orderBy('code')->get();
        $statuses = $this->statuses();

        return view('plans.edit', compact('plan', 'entities', 'objectives', 'statuses'));
    }

    public function update(Request $request, InstitutionalPlan $plan)
    {
        $validated = $request->validate($this->rules($plan));

        $plan->update($validated);

        return redirect()->route('plans.index')->with('success', 'Plan institucional actualizado correctamente.');
    }

    public function destroy(InstitutionalPlan $plan)
    {
        $plan->update(['status' => InstitutionalPlan::STATUS_INACTIVE]);

        return redirect()->route('plans.index')->with('success', 'Plan institucional desactivado correctamente.');
    }

    private function rules(?InstitutionalPlan $plan = null): array
    {
        return [
            'public_entity_id' => 'required|integer|exists:public_entities,id',
            'strategic_objective_id' => 'nullable|integer|exists:strategic_objectives,id',
            'code' => [
                'required',
                'string',
                'max:40',
                Rule::unique('institutional_plans', 'code')
                    ->where(fn ($query) => $query->where('public_entity_id', request('public_entity_id')))
                    ->ignore($plan?->id),
            ],
            'name' => 'required|string|max:220',
            'type' => 'required|string|max:80',
            'description' => 'nullable|string|max:1200',
            'start_year' => 'required|integer|min:2020|max:2100',
            'end_year' => 'required|integer|min:2020|max:2100|gte:start_year',
            'status' => ['required', Rule::in(array_keys($this->statuses()))],
        ];
    }

    private function statuses(): array
    {
        return [
            InstitutionalPlan::STATUS_DRAFT => 'Borrador',
            InstitutionalPlan::STATUS_REVIEW => 'En revision',
            InstitutionalPlan::STATUS_APPROVED => 'Aprobado',
            InstitutionalPlan::STATUS_INACTIVE => 'Inactivo',
        ];
    }
}
