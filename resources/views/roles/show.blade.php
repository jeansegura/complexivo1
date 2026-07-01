@extends('layouts.app')

@section('title', 'Detalle de rol')

@section('content')
    @include('partials.page-header', [
        'title' => $role->name,
        'subtitle' => 'Detalle del rol funcional',
        'backUrl' => route('roles.index'),
        'backLabel' => 'Volver a roles',
        'actionUrl' => route('roles.edit', $role),
        'actionLabel' => 'Editar rol',
    ])

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-1">
            <dl class="grid gap-6 px-6 py-6">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Codigo</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $role->slug }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nivel</dt>
                    <dd class="mt-1 text-sm font-medium text-slate-900">{{ $role->level }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt>
                    <dd class="mt-2">@include('roles.partials.status-badge', ['role' => $role])</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Descripcion</dt>
                    <dd class="mt-1 text-sm text-slate-700">{{ $role->description ?: 'Sin descripcion registrada.' }}</dd>
                </div>
            </dl>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:col-span-2">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-900">Permisos asignados</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($role->permissions->groupBy('module') as $module => $items)
                    <div class="px-6 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $module }}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($items as $permission)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                    {{ $permission->action }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-8 text-sm text-slate-600">Este rol aun no tiene permisos asignados.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
