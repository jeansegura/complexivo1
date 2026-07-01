@extends('layouts.app')

@section('title', 'Detalle de entidad')

@section('content')
    @include('partials.page-header', [
        'title' => $entity->name,
        'subtitle' => 'Detalle institucional',
        'backUrl' => route('entities.index'),
        'backLabel' => 'Volver a entidades',
        'actionUrl' => route('entities.edit', $entity),
        'actionLabel' => 'Editar entidad',
    ])

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-1">
            <dl class="grid gap-6 px-6 py-6">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">RUC</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $entity->ruc }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Codigo</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $entity->code ?: 'No registrado' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sector y tipo</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $entity->sector }} - {{ $entity->type }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                    <dd class="mt-2">@include('entities.partials.status-badge', ['entity' => $entity])</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Entidad superior</dt>
                    <dd class="mt-1 text-sm text-slate-700">{{ $entity->parent?->name ?: 'Sin entidad superior' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripcion</dt>
                    <dd class="mt-1 text-sm text-slate-700">{{ $entity->description ?: 'Sin descripcion registrada.' }}</dd>
                </div>
            </dl>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-2">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-900">Objetivos estrategicos asociados</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($entity->strategicObjectives as $objective)
                    <div class="px-6 py-4">
                        <p class="text-sm font-semibold text-slate-900">{{ $objective->code }} - {{ $objective->name }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $objective->start_year }} - {{ $objective->end_year }}</p>
                    </div>
                @empty
                    <p class="px-6 py-8 text-sm text-slate-600">Esta entidad aun no tiene objetivos estrategicos.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
