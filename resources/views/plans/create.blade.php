@extends('layouts.app')

@section('title', 'Nuevo plan')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nuevo plan institucional',
        'subtitle' => 'Registra la programacion institucional asociada a una entidad',
        'backUrl' => route('plans.index'),
        'backLabel' => 'Volver a planes',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('plans.store') }}" method="POST" class="p-6">
            @csrf

            @include('plans.partials.form', [
                'plan' => null,
                'entities' => $entities,
                'objectives' => $objectives,
                'statuses' => $statuses,
            ])

            @include('partials.form-actions', ['cancelUrl' => route('plans.index'), 'submitLabel' => 'Guardar plan'])
        </form>
    </div>
@endsection
