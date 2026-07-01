@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    @include('partials.page-header', [
        'title' => 'Roles',
        'subtitle' => 'Configuracion de perfiles funcionales y permisos',
        'actionUrl' => route('roles.create'),
        'actionLabel' => 'Nuevo rol',
    ])

    <form method="GET" action="{{ route('roles.index') }}" class="mb-5 grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-3">
        <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Buscar por nombre o codigo"
               class="rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200 md:col-span-2">

        <div class="flex gap-2">
            <select name="status" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                <option value="">Todos los estados</option>
                <option value="active" @selected(($filters['status'] ?? '') === 'active')>Activos</option>
                <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Inactivos</option>
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
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Rol</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nivel</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Permisos</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($roles as $role)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-900">{{ $role->name }}</p>
                                <p class="text-xs text-slate-500">{{ $role->slug }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $role->level }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $role->permissions_count }}</td>
                            <td class="px-5 py-4">
                                @include('roles.partials.status-badge', ['role' => $role])
                            </td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('roles.show', $role),
                                    'editUrl' => route('roles.edit', $role),
                                    'destroyUrl' => route('roles.destroy', $role),
                                    'destroyLabel' => 'Desactivar',
                                    'confirmMessage' => 'Desactivar este rol?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay roles registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Crea el primer rol funcional del sistema.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
