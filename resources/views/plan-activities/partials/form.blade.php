@include('partials.form-field', ['label' => 'Nombre de la actividad', 'name' => 'name', 'value' => old('name', $activity?->name), 'required' => true])
@include('partials.form-field', ['label' => 'Descripcion', 'name' => 'description', 'type' => 'textarea', 'value' => old('description', $activity?->description)])
@include('partials.form-field', ['label' => 'Unidad responsable', 'name' => 'responsible_unit', 'value' => old('responsible_unit', $activity?->responsible_unit), 'required' => true])
@include('partials.form-field', ['label' => 'Presupuesto', 'name' => 'budget', 'type' => 'number', 'value' => old('budget', $activity?->budget ?? '0.00'), 'min' => 0, 'step' => '0.01', 'required' => true])

<div class="grid gap-4 sm:grid-cols-2">
    @include('partials.form-field', ['label' => 'Fecha inicio', 'name' => 'start_date', 'type' => 'date', 'value' => old('start_date', $activity?->start_date?->format('Y-m-d'))])
    @include('partials.form-field', ['label' => 'Fecha fin', 'name' => 'end_date', 'type' => 'date', 'value' => old('end_date', $activity?->end_date?->format('Y-m-d'))])
</div>

@include('plan-activities.partials.status-select', [
    'statuses' => $statuses,
    'selected' => old('status', $activity?->status ?? \App\Models\PlanActivity::STATUS_PENDING),
])
