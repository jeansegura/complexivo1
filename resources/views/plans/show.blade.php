@extends('layouts.app')

@section('title', 'Detalle de plan')

@section('content')
    @include('partials.page-header', [
        'title' => $plan->code,
        'subtitle' => $plan->name,
        'backUrl' => route('plans.index'),
        'backLabel' => 'Volver a planes',
        'actionUrl' => route('plans.activities.create', $plan),
        'actionLabel' => 'Nueva actividad',
    ])

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-1">
            <dl class="grid gap-6 px-6 py-6">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Entidad</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $plan->publicEntity->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Objetivo</dt>
                    <dd class="mt-1 text-sm text-slate-700">{{ $plan->strategicObjective?->code ?: 'Sin objetivo asociado' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tipo y vigencia</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $plan->type }} - {{ $plan->start_year }} / {{ $plan->end_year }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                    <dd class="mt-2">@include('plans.partials.status-badge', ['plan' => $plan])</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripcion</dt>
                    <dd class="mt-1 text-sm text-slate-700">{{ $plan->description ?: 'Sin descripcion registrada.' }}</dd>
                </div>
            </dl>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Actividades del plan</h2>
                    <p class="mt-1 text-sm text-slate-500">Acciones operativas asociadas al plan institucional.</p>
                </div>
                <a href="{{ route('plans.activities.create', $plan) }}" class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Nueva actividad
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($plan->activities as $activity)
                    <div class="px-6 py-4">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $activity->name }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $activity->responsible_unit }} - ${{ number_format((float) $activity->budget, 2) }}</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $activity->start_date?->format('d/m/Y') ?: 'Sin inicio' }} - {{ $activity->end_date?->format('d/m/Y') ?: 'Sin fin' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                @include('plan-activities.partials.status-badge', ['activity' => $activity])
                                <a href="{{ route('plans.activities.edit', [$plan, $activity]) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">Editar</a>
                                <form action="{{ route('plans.activities.destroy', [$plan, $activity]) }}" method="POST" onsubmit="return confirm('Desactivar esta actividad?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">Desactivar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-8 text-sm text-slate-600">Este plan aun no tiene actividades registradas.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
