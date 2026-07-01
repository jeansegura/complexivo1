@extends('layouts.app')

@section('title', 'Planes institucionales')

@section('content')
    @include('partials.page-header', [
        'title' => 'Planes institucionales',
        'subtitle' => 'Programacion institucional vinculada a objetivos estrategicos',
        'actionUrl' => route('plans.create'),
        'actionLabel' => 'Nuevo plan',
    ])

    <form method="GET" action="{{ route('plans.index') }}" class="mb-5 grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-4">
        <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Buscar por codigo, nombre o tipo"
               class="rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200 md:col-span-2">

        <select name="public_entity_id" class="rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
            <option value="">Todas las entidades</option>
            @foreach ($entities as $entity)
                <option value="{{ $entity->id }}" @selected((int) ($filters['public_entity_id'] ?? 0) === $entity->id)>{{ $entity->name }}</option>
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
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Plan</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Entidad</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Objetivo</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Actividades</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($plans as $plan)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-900">{{ $plan->code }}</p>
                                <p class="text-sm text-slate-600">{{ $plan->name }}</p>
                                <p class="text-xs text-slate-500">{{ $plan->type }} - {{ $plan->start_year }} / {{ $plan->end_year }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $plan->publicEntity->name }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $plan->strategicObjective?->code ?: 'Sin objetivo' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $plan->activities_count }}</td>
                            <td class="px-5 py-4">@include('plans.partials.status-badge', ['plan' => $plan])</td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('plans.show', $plan),
                                    'editUrl' => route('plans.edit', $plan),
                                    'destroyUrl' => route('plans.destroy', $plan),
                                    'destroyLabel' => 'Desactivar',
                                    'confirmMessage' => 'Desactivar este plan?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay planes institucionales</p>
                                <p class="mt-1 text-sm text-slate-500">Crea un plan cuando existan entidades y objetivos registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
