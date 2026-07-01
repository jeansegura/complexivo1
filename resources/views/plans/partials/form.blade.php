<div class="mb-5">
    <label for="public_entity_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Entidad publica <span class="text-red-500">*</span></label>
    <select id="public_entity_id" name="public_entity_id" required
            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
        <option value="">Selecciona una entidad</option>
        @foreach ($entities as $entity)
            <option value="{{ $entity->id }}" @selected((int) old('public_entity_id', $plan?->public_entity_id) === $entity->id)>{{ $entity->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-5">
    <label for="strategic_objective_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Objetivo estrategico</label>
    <select id="strategic_objective_id" name="strategic_objective_id"
            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
        <option value="">Sin objetivo asociado</option>
        @foreach ($objectives as $objective)
            <option value="{{ $objective->id }}" @selected((int) old('strategic_objective_id', $plan?->strategic_objective_id) === $objective->id)>{{ $objective->code }} - {{ $objective->name }}</option>
        @endforeach
    </select>
</div>

@include('partials.form-field', ['label' => 'Codigo', 'name' => 'code', 'value' => old('code', $plan?->code), 'required' => true])
@include('partials.form-field', ['label' => 'Nombre del plan', 'name' => 'name', 'value' => old('name', $plan?->name), 'required' => true])
@include('partials.form-field', ['label' => 'Tipo de plan', 'name' => 'type', 'value' => old('type', $plan?->type ?? 'PEI'), 'required' => true])
@include('partials.form-field', ['label' => 'Descripcion', 'name' => 'description', 'type' => 'textarea', 'value' => old('description', $plan?->description)])

<div class="grid gap-4 sm:grid-cols-2">
    @include('partials.form-field', ['label' => 'Ano inicio', 'name' => 'start_year', 'type' => 'number', 'value' => old('start_year', $plan?->start_year ?? 2026), 'min' => 2020, 'required' => true])
    @include('partials.form-field', ['label' => 'Ano fin', 'name' => 'end_year', 'type' => 'number', 'value' => old('end_year', $plan?->end_year ?? 2029), 'min' => 2020, 'required' => true])
</div>

@include('plans.partials.status-select', [
    'statuses' => $statuses,
    'selected' => old('status', $plan?->status ?? \App\Models\InstitutionalPlan::STATUS_DRAFT),
])
