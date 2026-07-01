@extends('layouts.app')

@section('title', 'Nueva entidad')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nueva entidad publica',
        'subtitle' => 'Registra una institucion para asociar objetivos y planes',
        'backUrl' => route('entities.index'),
        'backLabel' => 'Volver a entidades',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('entities.store') }}" method="POST" class="p-6">
            @csrf

            @include('partials.form-field', ['label' => 'Nombre', 'name' => 'name', 'value' => old('name'), 'required' => true])
            @include('partials.form-field', ['label' => 'RUC', 'name' => 'ruc', 'value' => old('ruc'), 'required' => true])
            @include('partials.form-field', ['label' => 'Codigo institucional', 'name' => 'code', 'value' => old('code')])
            @include('partials.form-field', ['label' => 'Sector', 'name' => 'sector', 'value' => old('sector'), 'required' => true])
            @include('partials.form-field', ['label' => 'Tipo de entidad', 'name' => 'type', 'value' => old('type'), 'required' => true])

            <div class="mb-5">
                <label for="parent_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Entidad superior</label>
                <select id="parent_id" name="parent_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <option value="">Sin entidad superior</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" @selected((int) old('parent_id') === $parent->id)>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            @include('entities.partials.status-select', [
                'statuses' => $statuses,
                'selected' => old('status', \App\Models\PublicEntity::STATUS_ACTIVE),
            ])

            @include('partials.form-field', ['label' => 'Descripcion', 'name' => 'description', 'type' => 'textarea', 'value' => old('description')])

            @include('partials.form-actions', ['cancelUrl' => route('entities.index'), 'submitLabel' => 'Guardar entidad'])
        </form>
    </div>
@endsection
