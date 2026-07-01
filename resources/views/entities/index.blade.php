@extends('layouts.app')

@section('title', 'Entidades publicas')

@section('content')
    @include('partials.page-header', [
        'title' => 'Entidades publicas',
        'subtitle' => 'Registro institucional para la planificacion',
        'actionUrl' => route('entities.create'),
        'actionLabel' => 'Nueva entidad',
    ])

    <form method="GET" action="{{ route('entities.index') }}" class="mb-5 grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-4">
        <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Buscar por nombre, RUC o codigo"
               class="rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200 md:col-span-2">

        <select name="sector" class="rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
            <option value="">Todos los sectores</option>
            @foreach ($sectors as $sector)
                <option value="{{ $sector }}" @selected(($filters['sector'] ?? '') === $sector)>{{ $sector }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <select name="status" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                <option value="">Todos los estados</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                Filtrar
            </button>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Entidad</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Sector</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tipo</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Objetivos</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($entities as $entity)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-900">{{ $entity->name }}</p>
                                <p class="text-xs text-slate-500">RUC {{ $entity->ruc }} {{ $entity->code ? ' - '.$entity->code : '' }}</p>
                                @if ($entity->parent)
                                    <p class="mt-1 text-xs text-slate-500">Depende de {{ $entity->parent->name }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $entity->sector }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $entity->type }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $entity->strategic_objectives_count }}</td>
                            <td class="px-5 py-4">@include('entities.partials.status-badge', ['entity' => $entity])</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('entities.show', $entity),
                                    'editUrl' => route('entities.edit', $entity),
                                    'destroyUrl' => route('entities.destroy', $entity),
                                    'destroyLabel' => 'Desactivar',
                                    'confirmMessage' => 'Desactivar esta entidad?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay entidades registradas</p>
                                <p class="mt-1 text-sm text-slate-500">Crea la primera entidad publica del sistema.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
