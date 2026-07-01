@extends('layouts.app')

@section('title', 'Detalle de usuario')

@section('content')
    @include('partials.page-header', [
        'title' => $user->name,
        'subtitle' => 'Detalle del usuario institucional',
        'backUrl' => route('users.index'),
        'backLabel' => 'Volver a usuarios',
        'actionUrl' => route('users.edit', $user),
        'actionLabel' => 'Editar usuario',
    ])

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <dl class="grid gap-6 px-6 py-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rol</dt>
                <dd class="mt-2">@include('users.partials.role-badge', ['user' => $user])</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Registrado</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900">{{ $user->created_at?->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
@endsection
