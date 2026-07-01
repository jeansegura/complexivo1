<?php

namespace App\Http\Controllers;

use App\Models\PublicEntity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublicEntityController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'sector', 'status']);

        $entities = PublicEntity::query()
            ->with('parent')
            ->withCount('strategicObjectives')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('ruc', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($filters['sector'] ?? null, fn ($query, string $sector) => $query->where('sector', $sector))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->get();

        $sectors = PublicEntity::query()->select('sector')->distinct()->orderBy('sector')->pluck('sector');
        $statuses = $this->statuses();

        return view('entities.index', compact('entities', 'filters', 'sectors', 'statuses'));
    }

    public function create()
    {
        $parents = PublicEntity::query()->where('status', PublicEntity::STATUS_ACTIVE)->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('entities.create', compact('parents', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        PublicEntity::create($validated);

        return redirect()->route('entities.index')->with('success', 'Entidad publica creada correctamente.');
    }

    public function show(PublicEntity $entity)
    {
        $entity->load(['parent', 'children', 'strategicObjectives']);

        return view('entities.show', compact('entity'));
    }

    public function edit(PublicEntity $entity)
    {
        $parents = PublicEntity::query()
            ->where('id', '!=', $entity->id)
            ->where('status', PublicEntity::STATUS_ACTIVE)
            ->orderBy('name')
            ->get();
        $statuses = $this->statuses();

        return view('entities.edit', compact('entity', 'parents', 'statuses'));
    }

    public function update(Request $request, PublicEntity $entity)
    {
        $validated = $request->validate($this->rules($entity));

        $entity->update($validated);

        return redirect()->route('entities.index')->with('success', 'Entidad publica actualizada correctamente.');
    }

    public function destroy(PublicEntity $entity)
    {
        $entity->update(['status' => PublicEntity::STATUS_INACTIVE]);

        return redirect()->route('entities.index')->with('success', 'Entidad publica desactivada correctamente.');
    }

    private function rules(?PublicEntity $entity = null): array
    {
        return [
            'parent_id' => ['nullable', 'integer', 'exists:public_entities,id'],
            'name' => 'required|string|max:180',
            'ruc' => ['required', 'string', 'size:13', Rule::unique('public_entities', 'ruc')->ignore($entity?->id)],
            'code' => ['nullable', 'string', 'max:40', Rule::unique('public_entities', 'code')->ignore($entity?->id)],
            'sector' => 'required|string|max:120',
            'type' => 'required|string|max:120',
            'status' => ['required', Rule::in(array_keys($this->statuses()))],
            'description' => 'nullable|string|max:800',
        ];
    }

    private function statuses(): array
    {
        return [
            PublicEntity::STATUS_ACTIVE => 'Activa',
            PublicEntity::STATUS_INACTIVE => 'Inactiva',
        ];
    }
}
