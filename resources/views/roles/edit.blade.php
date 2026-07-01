@extends('layouts.app')

@section('title', 'Editar rol')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar rol',
        'subtitle' => $role->name,
        'backUrl' => route('roles.index'),
        'backLabel' => 'Volver a roles',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del rol</h2>
            <p class="mt-0.5 text-sm text-slate-500">Actualiza el nivel y los permisos asociados.</p>
        </div>

        <form action="{{ route('roles.update', $role) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name', $role->name),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Codigo',
                'name' => 'slug',
                'value' => old('slug', $role->slug),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Descripcion',
                'name' => 'description',
                'type' => 'textarea',
                'value' => old('description', $role->description),
            ])

            @include('partials.form-field', [
                'label' => 'Nivel de acceso',
                'name' => 'level',
                'type' => 'number',
                'value' => old('level', $role->level),
                'min' => 1,
                'required' => true,
            ])

            <label class="mb-5 flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-slate-500" @checked(old('is_active', $role->is_active))>
                Rol activo
            </label>

            @include('roles.partials.permission-checkboxes', [
                'permissions' => $permissions,
                'selected' => collect(old('permissions', $role->permissions->pluck('id')->all()))->map(fn ($id) => (int) $id)->all(),
            ])

            @include('partials.form-actions', [
                'cancelUrl' => route('roles.index'),
                'submitLabel' => 'Actualizar rol',
            ])
        </form>
    </div>
@endsection
