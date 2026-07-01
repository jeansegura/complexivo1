@extends('layouts.app')

@section('title', 'Editar objetivo')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar objetivo estrategico',
        'subtitle' => $objective->code,
        'backUrl' => route('objectives.index'),
        'backLabel' => 'Volver a objetivos',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('objectives.update', $objective) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="public_entity_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Entidad publica <span class="text-red-500">*</span></label>
                <select id="public_entity_id" name="public_entity_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @foreach ($entities as $entity)
                        <option value="{{ $entity->id }}" @selected((int) old('public_entity_id', $objective->public_entity_id) === $entity->id)>{{ $entity->name }}</option>
                    @endforeach
                </select>
            </div>

            @include('partials.form-field', ['label' => 'Codigo', 'name' => 'code', 'value' => old('code', $objective->code), 'required' => true])
            @include('partials.form-field', ['label' => 'Nombre del objetivo', 'name' => 'name', 'value' => old('name', $objective->name), 'required' => true])
            @include('partials.form-field', ['label' => 'Descripcion', 'name' => 'description', 'type' => 'textarea', 'value' => old('description', $objective->description)])
            @include('partials.form-field', ['label' => 'Alineacion PND', 'name' => 'pnd_alignment', 'value' => old('pnd_alignment', $objective->pnd_alignment)])
            @include('partials.form-field', ['label' => 'Alineacion ODS', 'name' => 'ods_alignment', 'value' => old('ods_alignment', $objective->ods_alignment)])

            <div class="grid gap-4 sm:grid-cols-2">
                @include('partials.form-field', ['label' => 'Ano inicio', 'name' => 'start_year', 'type' => 'number', 'value' => old('start_year', $objective->start_year), 'min' => 2020, 'required' => true])
                @include('partials.form-field', ['label' => 'Ano fin', 'name' => 'end_year', 'type' => 'number', 'value' => old('end_year', $objective->end_year), 'min' => 2020, 'required' => true])
            </div>

            @include('objectives.partials.status-select', [
                'statuses' => $statuses,
                'selected' => old('status', $objective->status),
            ])

            @include('partials.form-actions', ['cancelUrl' => route('objectives.index'), 'submitLabel' => 'Actualizar objetivo'])
        </form>
    </div>
@endsection
