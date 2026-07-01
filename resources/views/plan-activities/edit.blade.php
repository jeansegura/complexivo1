@extends('layouts.app')

@section('title', 'Editar actividad')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar actividad',
        'subtitle' => $activity->name,
        'backUrl' => route('plans.show', $plan),
        'backLabel' => 'Volver al plan',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('plans.activities.update', [$plan, $activity]) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            @include('plan-activities.partials.form', [
                'activity' => $activity,
                'statuses' => $statuses,
            ])

            @include('partials.form-actions', ['cancelUrl' => route('plans.show', $plan), 'submitLabel' => 'Actualizar actividad'])
        </form>
    </div>
@endsection
