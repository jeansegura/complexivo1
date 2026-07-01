@extends('layouts.app')

@section('title', 'Editar plan')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar plan institucional',
        'subtitle' => $plan->code,
        'backUrl' => route('plans.index'),
        'backLabel' => 'Volver a planes',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('plans.update', $plan) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            @include('plans.partials.form', [
                'plan' => $plan,
                'entities' => $entities,
                'objectives' => $objectives,
                'statuses' => $statuses,
            ])

            @include('partials.form-actions', ['cancelUrl' => route('plans.index'), 'submitLabel' => 'Actualizar plan'])
        </form>
    </div>
@endsection
