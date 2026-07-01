<?php

namespace App\Http\Controllers;

use App\Models\PublicEntity;
use App\Models\StrategicObjective;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StrategicObjectiveController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'public_entity_id', 'status']);

        $objectives = StrategicObjective::query()
            ->with('publicEntity')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('pnd_alignment', 'like', "%{$search}%")
                        ->orWhere('ods_alignment', 'like', "%{$search}%");
                });
            })
            ->when($filters['public_entity_id'] ?? null, fn ($query, string $entityId) => $query->where('public_entity_id', $entityId))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->get();

        $entities = PublicEntity::query()->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('objectives.index', compact('objectives', 'entities', 'filters', 'statuses'));
    }

    public function create()
    {
        $entities = PublicEntity::query()->where('status', PublicEntity::STATUS_ACTIVE)->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('objectives.create', compact('entities', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        StrategicObjective::create($validated);

        return redirect()->route('objectives.index')->with('success', 'Objetivo estrategico creado correctamente.');
    }

    public function show(StrategicObjective $objective)
    {
        $objective->load('publicEntity');

        return view('objectives.show', compact('objective'));
    }

    public function edit(StrategicObjective $objective)
    {
        $entities = PublicEntity::query()->where('status', PublicEntity::STATUS_ACTIVE)->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('objectives.edit', compact('objective', 'entities', 'statuses'));
    }

    public function update(Request $request, StrategicObjective $objective)
    {
        $validated = $request->validate($this->rules($objective));

        $objective->update($validated);

        return redirect()->route('objectives.index')->with('success', 'Objetivo estrategico actualizado correctamente.');
    }

    public function destroy(StrategicObjective $objective)
    {
        $objective->update(['status' => StrategicObjective::STATUS_INACTIVE]);

        return redirect()->route('objectives.index')->with('success', 'Objetivo estrategico desactivado correctamente.');
    }

    private function rules(?StrategicObjective $objective = null): array
    {
        return [
            'public_entity_id' => 'required|integer|exists:public_entities,id',
            'code' => [
                'required',
                'string',
                'max:40',
                Rule::unique('strategic_objectives', 'code')
                    ->where(fn ($query) => $query->where('public_entity_id', request('public_entity_id')))
                    ->ignore($objective?->id),
            ],
            'name' => 'required|string|max:220',
            'description' => 'nullable|string|max:1200',
            'pnd_alignment' => 'nullable|string|max:180',
            'ods_alignment' => 'nullable|string|max:180',
            'start_year' => 'required|integer|min:2020|max:2100',
            'end_year' => 'required|integer|min:2020|max:2100|gte:start_year',
            'status' => ['required', Rule::in(array_keys($this->statuses()))],
        ];
    }

    private function statuses(): array
    {
        return [
            StrategicObjective::STATUS_DRAFT => 'Borrador',
            StrategicObjective::STATUS_ACTIVE => 'Activo',
            StrategicObjective::STATUS_INACTIVE => 'Inactivo',
        ];
    }
}
