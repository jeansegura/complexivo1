@extends('layouts.app')

@section('title', 'Detalle de objetivo')

@section('content')
    @include('partials.page-header', [
        'title' => $objective->code,
        'subtitle' => $objective->name,
        'backUrl' => route('objectives.index'),
        'backLabel' => 'Volver a objetivos',
        'actionUrl' => route('objectives.edit', $objective),
        'actionLabel' => 'Editar objetivo',
    ])

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <dl class="grid gap-6 px-6 py-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Entidad publica</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $objective->publicEntity->name }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                <dd class="mt-2">@include('objectives.partials.status-badge', ['objective' => $objective])</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">PND</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $objective->pnd_alignment ?: 'Sin alineacion PND' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">ODS</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $objective->ods_alignment ?: 'Sin alineacion ODS' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Vigencia</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $objective->start_year }} - {{ $objective->end_year }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripcion</dt>
                <dd class="mt-1 text-sm text-slate-700">{{ $objective->description ?: 'Sin descripcion registrada.' }}</dd>
            </div>
        </dl>
    </div>
@endsection
