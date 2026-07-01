@extends('layouts.app')

@section('title', 'Nueva actividad')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nueva actividad',
        'subtitle' => $plan->code.' - '.$plan->name,
        'backUrl' => route('plans.show', $plan),
        'backLabel' => 'Volver al plan',
    ])

    <div class="max-w-3xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('plans.activities.store', $plan) }}" method="POST" class="p-6">
            @csrf

            @include('plan-activities.partials.form', [
                'activity' => null,
                'statuses' => $statuses,
            ])

            @include('partials.form-actions', ['cancelUrl' => route('plans.show', $plan), 'submitLabel' => 'Guardar actividad'])
        </form>
    </div>
@endsection
